<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;


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
Route::post('/register/email',[AuthController::class,'register_confirm_email']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/check/email',[AuthController::class,'change_password_confirm_email']);

Route::post('/login', [AuthController::class, 'login']);


Route::post('/change/password',[AuthController::class,'change_password']);

//Route::get('/cities',[ServicesController::class,'getCities']);



Route::group(['middleware'=>['auth:sanctum']], function(){ // control middleware !!
                                                             
    Route::post('/logout', [AuthController::class, 'logout']); //ne kete rast /logout nuk duhet mu kon autorizim
                                                                //por psh user profile ose payment page oe tjerat
                                                                //ne rast se nuk eshte login nuk ka drejt me i 
                                                                //pa keto faqe
    Route::get('/user',[UserController::class,'show']);
    Route::patch('/user/details',[UserController::class,'update']); //PUT - update a resource (by replacing it with a new version)*
                                                                    //PATCH - update part of a resource (if available and appropriate)
    Route::delete('/user/delete',[UserController::class,'delete_user']);
    
    Route::get('/user/posts',[PostController::class,'get_user_posts']);

    Route::post('/offerhelp/createPost',[PostController::class,'create_post']); //endpoint url 
 //   Route::get('/seekhelp/posts',[PostController::class,'get_posts_by_queries']);
    Route::get('/seekhelp/posts/{id}',[PostController::class,'get_post_by_id']);

    Route::patch('/seekhelp/posts/{id}',[PostController::class,'update_post_by_id']);
    Route::delete('/seekhelp/posts/{id}',[PostController::class,'delete_post_by_id']);

});
Route::get('/services',[PostController::class,'get_services']);



Route::get('/countries',[PostController::class,'get_countries']);
Route::get('/cities',[PostController::class,'get_cities']);
Route::get('/regions',[PostController::class,'get_regions']);
Route::get('/genders',[PostController::class,'get_genders']);

Route::get('/seekhelp/posts',[PostController::class,'get_posts_by_queries']);