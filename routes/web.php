<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UnitOwnerController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\AmenitieController;
use App\Http\Controllers\BillingController;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/clear-config', function() {
    \Artisan::call('config:clear');
      return \Artisan::output();
  });
  Route::get('/clear-cache', function() {
   \Artisan::call('cache:clear');
      return \Artisan::output();
  });
  Route::get('/clear-view', function() {
   \Artisan::call('view:clear');
    return \Artisan::output();
  });
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    
  
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

    Route::resource('projects', ProjectController::class);

    Route::resource('owners', OwnerController::class);
    Route::get('owners_import_view', [OwnerController::class, 'importExportView']);
    Route::get('exportowners', [OwnerController::class, 'export'])->name('export');
    Route::post('import', [OwnerController::class, 'import'])->name('import');
    Route::get('downloadsample', [OwnerController::class, 'downloadfile'])->name('downloadfile');
    

    Route::resource('tenants', TenantController::class);
    Route::get('tenant_import_view', [TenantController::class, 'importExportView']);
    Route::get('exporttenant', [TenantController::class, 'export'])->name('exporttenant');
    Route::post('importtenant', [TenantController::class, 'import'])->name('importtenant');
    Route::get('downloadsampletenant', [TenantController::class, 'downloadfile'])->name('downloadsampletenant');

    Route::resource('units', UnitController::class);
    Route::get('unitimportview', [UnitController::class, 'unit_import_view'])->name('unitimportview');
    Route::get('exportunits', [UnitController::class, 'unit_export'])->name('exportunits');
    Route::post('unitimport', [UnitController::class, 'unit_import'])->name('unitimport');
    Route::get('downloadunitsample', [UnitController::class, 'downloadfile'])->name('downloadunitsample');
   
    //Route::resource('unitowners', UnitOwnerController::class);
    

    Route::resource('leases', LeaseController::class);
    Route::get('fetchownertenant', [LeaseController::class,'fetch_owner_tenant'])->name('fetchownertenant');
    Route::get('fetchunits', [LeaseController::class,'fetch_units'])->name('fetchunits');
    Route::get('fetchunitowner', [LeaseController::class,'fetch_unit_owner'])->name('fetchunitowner');

    Route::resource('amenities', AmenitieController::class);

    Route::resource('billings', BillingController::class);
    Route::get('billinginvoice/{id}',  [BillingController::class,'billinginvoice']);
    Route::post('billingstatus',  [BillingController::class,'billing_status'])->name('billingstatus');
    Route::get('activity_log/{type}', function($type){
        $activities =  Activity::where('log_name',$type )->whereMonth('created_at', Carbon::now()->month)->get();
        return view('activity_log',compact('activities','type'));
    });
});

