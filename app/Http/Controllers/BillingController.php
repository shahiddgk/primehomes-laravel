<?php
    
namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Billing;
use Illuminate\Http\Request;
use App\Imports\BillingImport;
use App\Models\BillingDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Response;
class BillingController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $billings = Billing::with('unitowner','leaseto','billing_detail','building')->latest()->get();
        //dd($billings);
        
        return view('billings.index',compact('billings'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('billings.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        request()->validate([
           'month' => 'required',
           'year' => 'required',
           'billing_file' => 'required',

        ]);
       
        $year = $request->input('year');
        $month = $request->input('month');
        $result =  Excel::import(new BillingImport($year,$month),request()->file('billing_file'));
       
        return redirect()->route('billings.index')
                        ->with('success','Excel Imported Successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing  $product
     * @return \Illuminate\Http\Response
     */
   
    public function billinginvoice($id){
        $billings = Billing::where('id',$id)->with('unitowner','building')->first();
        $current_assoication_dues = BillingDetail::where('billing_id',$id)->where('type','default')->pluck('price')->first();
        $current_waterbill = BillingDetail::where('billing_id',$id)->where('type','water')->first();
        $current_violation = BillingDetail::where('billing_id',$id)->where('type','violation')->pluck('price')->first();
        $current_membership = BillingDetail::where('billing_id',$id)->where('type','membership')->pluck('price')->first();

        //getting previous water reading
        $previous_waterreading = '';
        $lastmonthid = Billing::select('id')->where('project_id',$billings->project_id)->where('unit_no',$billings->unit_no)->where('id','<>',$id)->orderBy('month', 'ASC')->first();
        if($lastmonthid){
            $previous_waterreading = BillingDetail::where('billing_id',$lastmonthid->id)->where('type','water')->pluck('current_reading')->first();
        }
   
        
        //getting past unpaid dues
        $pastassociationdues = 0;
        $pastviolationdues = 0;
        $pastwaterdues = 0;
        $pastmembershipdues = 0;
        $periodcovered = '';
        $unpaidduesids = Billing::select('id')->where('project_id',$billings->project_id)->where('unit_no',$billings->unit_no)->where('id','<>',$id)->where('status','pending')->get()->toArray();
        
        if(count($unpaidduesids)>0){
        $start = Billing::select('month','year')->where('project_id',$billings->project_id)->where('unit_no',$billings->unit_no)->where('id','<>',$id)->where('status','pending')->orderBy('month', 'DESC')->first();
        $end = Billing::select('month','year')->where('project_id',$billings->project_id)->where('unit_no',$billings->unit_no)->where('id','<>',$id)->where('status','pending')->orderBy('month', 'ASC')->first();
       
        $periodcovered = $start->month.' '.$start->year.'-'.$end->month.' '.$end->year;
     
        $unpaiddues = BillingDetail::whereIn('billing_id',$unpaidduesids)->get();
            $lastmonthreading = BillingDetail::where('billing_id',$end->id)->where('type','water')->first();
            $i = 0;
            $len = count($unpaiddues);
            foreach($unpaiddues as $unpaid){
                switch ($unpaid->type) {
                    case 'default':
                        $pastassociationdues += $unpaid->price;
                      break;
                    case 'water':
                        $pastwaterdues += $unpaid->price*$unpaid->consumption;
                      break;
                    case 'violation':
                        $pastviolationdues += $unpaid->price;
                      break;
                    
                      case 'membership':
                        $pastmembershipdues += $unpaid->price;
                        break;
                  }
                 
                
                $i++;
            }
        }
        
      
        
        return view('billings.invoice',compact('billings','current_assoication_dues','current_waterbill','current_violation','current_membership','pastassociationdues','pastwaterdues','periodcovered','previous_waterreading','pastviolationdues','pastmembershipdues'));
    }

    public function billing_status(Request $request){
       
        Billing::where('id',$request->id)->update(['status'=>$request->status]);
       return true;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Billing  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billing $billing)
    {
        BillingDetail::where('billing_id',$billing->id)->delete();
        $billing->delete();
        return redirect()->route('billings.index')
                        ->with('success','Billing record deleted successfully');
    }

    
}