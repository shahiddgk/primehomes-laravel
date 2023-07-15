<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Lease;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Unit;
use App\Models\Project;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $project = Project::get();
        if(auth()->user()->type=='Owner'){
           $ownerinfo = Owner::where('primary_email',auth()->user()->email)->first();
           $myunits = Unit::with('lease')->where('owner_id',$ownerinfo->id)->get();
           //dd($myunits);
           $unitids = array_column($myunits->toArray(), 'id');
         
           $mybills=  Billing::with('building','unitowner')->whereIn('unit_no',$unitids)->latest()->take(10)->get();
          
            return view('userdashboard',compact('project','myunits','mybills'));
        }
        
        $projectCount = $project->count();
        $owner = Owner::where('type','owner')->get();
        $ownerCount = $owner->count();
        $tenant = Owner::where('type','tenant')->get();
        $tenantCount = $tenant->count();
        $unit = Unit::get();
        $unitCount = $unit->count();
        
        return view('home',compact('projectCount','ownerCount','unitCount','tenantCount'));
    }
}
