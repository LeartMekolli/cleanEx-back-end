<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServicesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('/register', [AuthController::class, 'register']);


Route::post('/login', [AuthController::class, 'login']);
Route::post('/checkMail',[AuthController::class,'checkMail']);

Route::post('/changePassword',[AuthController::class,'changePassword']);

Route::get('/cities',[ServicesController::class,'getCities']);
Route::get('/jobs',[ServicesController::class,'getJobs']);


Route::group(['middleware'=>['auth:sanctum']], function(){ // control middleware !!
                                                             
    Route::post('/logout', [AuthController::class, 'logout']); //ne kete rast /logout nuk duhet mu kon autorizim
                                                                //por psh user profile ose payment page oe tjerat
                                                                //ne rast se nuk eshte login nuk ka drejt me i 
                                                                //pa keto faqe
    Route::get('/user',[UserController::class,'show']);
    Route::patch('/user/details',[UserController::class,'update']); //PUT - update a resource (by replacing it with a new version)*
                                                                    //PATCH - update part of a resource (if available and appropriate)
    Route::delete('/user/delete',[UserController::class,'deleteUser']);
    
    Route::get('/user/services',[ServicesController::class,'getUserServices']);

    Route::post('/offerhelp/createService',[ServicesController::class,'createService']);
    Route::get('/seekhelp/services',[ServicesController::class,'getServices']);
    Route::get('/seekhelp/services/{id}',[ServicesController::class,'getServicesById']);

    Route::patch('/seekhelp/services/{id}',[ServicesController::class,'updateServiceById']);
    Route::delete('/seekhelp/services/{id}',[ServicesController::class,'deleteServiceById']);
    
});
Route::get('/getJobs',[ServicesController::class,'getJobs']);
/* Route::get('/user',[UserController::class,'show'])->middleware('auth-sanctum'); */


