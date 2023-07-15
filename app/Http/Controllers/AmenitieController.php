<?php
    
namespace App\Http\Controllers;
    
use App\Models\Amenitie;
use Illuminate\Http\Request;
use Image;
class AmenitieController extends Controller
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
        
        $amenities = Amenitie::latest()->get();
        return view('amenities.index',compact('amenities'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('amenities.create');
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
            'name' => 'required|unique:amenities',
            'charges' => 'required',
        ]);
    
     
        
        Amenitie::create($request->all());
    
        return redirect()->route('amenities.index')
                        ->with('success','Amenity created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Amenitie $amenity)
    {
        return view('amenities.edit',compact('amenity'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Amenitie  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amenitie $amenity)
    {
      
        request()->validate([
            'name' => 'required|unique:amenities,id,'.$amenity->id,
            'charges' => 'required'
        ]);
        
       
        
        $amenity->update($request->all());
    
        return redirect()->route('amenities.index')
                        ->with('success','Amenity updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Amenitie  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amenitie $amenity)
    {
        $amenity->delete();
    
        return redirect()->route('amenities.index')
                        ->with('success','Amenity deleted successfully');
    }

}