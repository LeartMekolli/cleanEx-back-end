<?php

use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::post('/createService', [ServicesController::class, 'createService']);
    Route::get('/getServices', [ServicesController::class, 'getServices']);
    Route::get('/getService/{id}', [ServicesController::class, 'getServicesById']);
    Route::get('/deleteService/{id}', [ServicesController::class, 'deleteServiceById']);
    Route::patch('/updateService/{id}', [ServicesController::class, 'updateServiceById']);
});