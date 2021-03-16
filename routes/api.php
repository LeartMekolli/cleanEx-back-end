<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


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



Route::group(['middleware'=>['auth:sanctum']], function(){ // control middleware !!
                                                             
    Route::post('/logout', [AuthController::class, 'logout']); //ne kete rast /logout nuk duhet mu kon autorizim
                                                                //por psh user profile ose payment page oe tjerat
                                                                //ne rast se nuk eshte login nuk ka drejt me i 
                                                                //pa keto faqe
    Route::get('/user',[UserController::class,'show']);
    Route::get('/user/service',[UserController::class,'update']);
    
});

/* Route::get('/user',[UserController::class,'show'])->middleware('auth-sanctum'); */


