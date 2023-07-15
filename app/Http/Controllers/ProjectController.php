<?php
    
namespace App\Http\Controllers;
    
use App\Models\Project;
use Illuminate\Http\Request;
use Image;
class ProjectController extends Controller
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
        
        $buildings = Project::latest()->paginate(5);
        return view('projects.index',compact('buildings'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
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
            'building_id' => 'required|unique:projects,building_id',
            'name' => 'required',
            'address' => 'required',
            'phase'=> 'required',
            'association_dues' => 'required'

        ]);
        
        $data = $request->all();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
         
            $destinationPath = public_path('buildings/thumbnail');
            $img = Image::make($image->path());
            $result = $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
           
       
            $destinationPath = public_path('buildings');
            $image->move($destinationPath, $input['imagename']);
            $data['image'] = $input['imagename'];

         }
        
        Project::create($data);
    
        return redirect()->route('projects.index')
                        ->with('success','Building created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit',compact('project'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        request()->validate([
            'building_id' => 'required|unique:projects,building_id,'.$project->id,
            'name' => 'required',
            'address' => 'required',
            'phase' => 'required',
            'association_dues' => 'required'

        ]);
        
        $data = $request->all();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
         
            $destinationPath = public_path('buildings/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
           
       
            $destinationPath = public_path('buildings');
            $image->move($destinationPath, $input['imagename']);
            $data['image'] = $input['imagename'];

        }
        
        $project->update($data);
    
        return redirect()->route('projects.index')
                        ->with('success','Building updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
    
        return redirect()->route('projects.index')
                        ->with('success','Building deleted successfully');
    }

}