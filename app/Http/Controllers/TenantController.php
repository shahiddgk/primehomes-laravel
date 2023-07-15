<?php
    
namespace App\Http\Controllers;
    
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Exports\TenantExport;
use App\Imports\TenantImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Response;
use Str;
class TenantController extends Controller
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
        $tenants = Owner::where('type','tenant')->latest()->get();
        return view('tenants.index',compact('tenants'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.create');
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
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'middlename' => 'required',
            'primary_email' => 'required|unique:users,email',
            'secondary_email' => 'required',
            'alternate_email' => 'required',
            'landline' => 'required',
            'primary_mobile' => 'required',
            'secondary_mobile' => 'required',
            'contact_person' => 'required',
            'contact_number' => 'required',

        ]);
        $data = $request->all();
        $data['type'] = 'tenant';
        if($request->hasFile('valid_id')){
            $image = $request->file('valid_id');
            $input['imagename'] = Str::slug($image->getClientOriginalName(), '-').'-'.time().'.'.$image->extension();
         
            $destinationPath = public_path('ownersdocument');
            $image->move($destinationPath, $input['imagename']);
            $data['valid_id'] = $input['imagename'];

        }
        if($request->hasFile('other_document')){
            $image = $request->file('other_document');
            $input['imagename'] = Str::slug($image->getClientOriginalName(), '-').'-'.time().'.'.$image->extension();
         
            $destinationPath = public_path('ownersdocument');
            $image->move($destinationPath, $input['imagename']);
            $data['other_document'] = $input['imagename'];

        }
        Owner::create($data);
        User::create([
            'name'     => $request->firstname.''.$request->lastname,
            'email'    => $request->primary_email,
            'type'     => 'Owner',
            'password' => Hash::make('123456'),
        ]);
        event(new UserRegistered($request->primary_email));
        return redirect()->route('tenants.index')
                        ->with('success','Tenant created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Owner  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $tenant)
    {
        return view('tenants.edit',compact('tenant'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Owner  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $tenant)
    {
        request()->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'middlename' => 'required',
            'primary_email' => 'required',
            'secondary_email' => 'required',
            'alternate_email' => 'required',
            'landline' => 'required',
            'primary_mobile' => 'required',
            'secondary_mobile' => 'required',
            'contact_person' => 'required',
            'contact_number' => 'required',

        ]);
    
        $tenant->update($request->all());
    
        return redirect()->route('tenants.index')
                        ->with('success','Tenant updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Owner  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $tenant)
    {
        $tenant->delete();
        User::where('email',$tenant->primary_email)->delete();
        return redirect()->route('tenants.index')
                        ->with('success','Tenant deleted successfully');
    }

    public function importExportView()
    {
       return view('tenants.import');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new TenantExport, 'Tenants.xlsx');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        request()->validate([
           
            'file' => 'required',

        ]);
        
        Excel::import(new TenantImport,request()->file('file'));
             
        return redirect()->route('tenants.index')->with('success','Data imported Successfully');
    }

    public function downloadfile()
    {
        $filepath = public_path('tenantsample.xlsx');
        return Response::download($filepath); 
    }
}