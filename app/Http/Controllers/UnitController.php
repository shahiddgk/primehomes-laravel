<?php
    
namespace App\Http\Controllers;
    
use App\Models\Unit;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Exports\UnitExport;
use App\Imports\UnitImport;
use App\Models\Owner;
use Maatwebsite\Excel\Facades\Excel;
use File;
use Response;
class UnitController extends Controller
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
        //\DB::enableQueryLog();
        //$units = Unit::with('building','owner')->latest();
        $units = Unit::query()

        ->leftjoin('projects as p','p.id', '=', 'units.project_id')
        ->leftjoin('owners as or','or.id', '=', 'units.owner_id')
        ->get([
            'units.*', //to get ids and timestamps
            'or.title',
            'or.firstname',
            'or.lastname',
            'p.building_id',
            'p.name as building_name',
            'p.phase'
        ]);
     
        //dd(\DB::getQueryLog());
        return view('units.index',compact('units'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::latest()->get();
        $owners = Owner::where('type','owner')->latest()->get();
        return view('units.create',compact('projects','owners'));
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
            'project_id' => 'required',
            'unit_no' => 'required',
            'floor_area'=> 'required',
            'parking' => 'required',
            'slot_no' => 'required_if:parking,Y',
            'parking_area' => 'required_if:parking,Y',
            'parking_location' => 'required_if:parking,Y'

        ]);
        if (Unit::where('unit_no', '=', $request->unit_no)->where('project_id', '=', $request->project_id)->exists()) {
            return redirect()->route('units.create')
            ->with('destroy','Unit No: '.$request->unit_no.' Already Exist In current Building');
         }
        Unit::create($request->all());
    
        return redirect()->route('units.index')
                        ->with('success','Unit created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        $owners = Owner::where('type','owner')->latest()->get();
        $projects = Project::latest()->get();
        return view('units.edit',compact('unit','projects','owners'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        
        request()->validate([
            'project_id' => 'required',
            'unit_no' => 'required',
            'floor_area'=> 'required',
            'parking' => 'required',
            'slot_no' => 'required_if:parking,Y',
            'parking_area' => 'required_if:parking,Y',
            'parking_location' => 'required_if:parking,Y'

        ]);
        
       
        if (Unit::where('id', '!=', $unit->id)->where('unit_no', '=', $request->unit_no)->where('project_id', '=', $request->project_id)->exists()) {
            return redirect()->back()
            ->with('destroy','Unit No: '.$request->unit_no.' Already Exist In current Building');
         }
        $unit->update($request->all());
    
        return redirect()->route('units.index')
                        ->with('success','Unit updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
    
        return redirect()->route('units.index')
                        ->with('success','Unit deleted successfully');
    }


    public function unit_import_view()
    {
       return view('units.import');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function unit_export() 
    {
        return Excel::download(new UnitExport, 'unit.xlsx');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function unit_import() 
    {
        request()->validate([
           
            'file' => 'required',

        ]);
        
        Excel::import(new UnitImport,request()->file('file'));
             
        return redirect()->route('units.index')
                        ->with('success','Data imported Successfully');
    }

    public function downloadfile()
    {
        $filepath = public_path('units.xlsx');
        return Response::download($filepath); 
    }
}