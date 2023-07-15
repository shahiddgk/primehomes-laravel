<?php
    
namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Exports\OnwerExport;
use App\Imports\OwnerImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Response;
use Str;
class OwnerController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:owner-list|owner-create|owner-edit|owner-delete', ['only' => ['index']]);
        $this->middleware('permission:owner-create', ['only' => ['create','store']]);
        $this->middleware('permission:owner-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:owner-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::where('type','owner')->latest()->get();
        return view('owners.index',compact('owners'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owners.create');
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
            'primary_email' => 'required|unique:users,email',
            'primary_mobile' => 'required',
            'representative' => 'required',
            'contact_person' => 'required_if:representative,Y',
            'contact_number' => 'required_if:representative,Y',
            'valid_id' => 'sometimes|mimes:jpeg,jpg,png,docx|max:4000',
            'other_document' => 'sometimes|mimes:jpeg,jpg,png,docx|max:4000',

        ]);
    
        $data = $request->all();
   
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
       // dd($data); exit;
        Owner::create($data);
        User::create([
            'name'     => $request->firstname.''.$request->lastname,
            'email'    => $request->primary_email,
            'type'     => 'Owner',
            'password' => Hash::make('123456'),
        ]);
       
        
       // event(new UserRegistered($request->primary_email));
        return redirect()->route('owners.index')
                        ->with('success','Owner created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Owner  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $owner)
    {
        return view('owners.edit',compact('owner'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Owner  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $owner)
    {
        $userid = User::where('email',$owner->primary_email)->pluck('id')->first();
        request()->validate([
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'primary_email' => 'required|unique:users,email,'.$userid,
            'primary_mobile' => 'required',
            'representative' => 'required',
            'contact_person' => 'required_if:representative,Y',
            'contact_number' => 'required_if:representative,Y',
            'valid_id' => 'sometimes|mimes:jpeg,jpg,png,docx|max:4000',
            'other_document' => 'sometimes|mimes:jpeg,jpg,png,docx|max:4000',

        ]);
        //gypakycuza@mailinator.com
        $data = $request->all();
   
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
        $owner->update($data);
    
        return redirect()->route('owners.index')
                        ->with('success','Owner updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Owner  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();
        User::where('email',$owner->primary_email)->delete();
        return redirect()->route('owners.index')
                        ->with('success','Owner deleted successfully');
    }

    public function importExportView()
    {
       return view('owners.import');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new OnwerExport, 'Owners.xlsx');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        request()->validate([
           
            'file' => 'required',

        ]);
        
        Excel::import(new OwnerImport,request()->file('file'));
             
        return redirect()->route('owners.index')
                        ->with('success','Data imported Successfully');
    }

    public function downloadfile()
    {
        $filepath = public_path('sample.xlsx');
        return Response::download($filepath); 
    }
}