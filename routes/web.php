<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StripePaymentController;

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

/* Route::get('/', function () {
    return view('welcome');
}); 
 */
//Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/email',[AuthController::class,'register_confirm_email']);
//Route::post('/register', [AuthController::class, 'register']);
Route::post('/check/email',[AuthController::class,'change_password_confirm_email']);

Route::post('/change/password',[AuthController::class,'change_password']);


Route::group(['middleware'=>['auth:sanctum']], function(){


    Route::post('/logout', [AuthController::class, 'logout']); //ne kete rast /logout nuk duhet mu kon autorizim
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/user',[UserController::class,'show']);
    Route::patch('/user/details',[UserController::class,'update']); 
    Route::delete('/user/delete',[UserController::class,'delete_user']);
    Route::get('/user/posts',[PostController::class,'get_user_posts']);
    Route::post('/offerhelp/createPost',[PostController::class,'create_post']); 
    Route::get('/seekhelp/posts/{id}',[PostController::class,'get_post_by_id']);
    Route::patch('/seekhelp/posts/{id}',[PostController::class,'update_post_by_id']);
    Route::delete('/seekhelp/posts/{id}',[PostController::class,'delete_post_by_id']);
    Route::get('/user/details',[UserController::class,'check_user_details']);
    
});




Route::get('/services',[PostController::class,'get_services']);



Route::get('/countries',[PostController::class,'get_countries']);
Route::get('/cities',[PostController::class,'get_cities']);
Route::get('/regions',[PostController::class,'get_regions']);
Route::get('/genders',[PostController::class,'get_genders']);

Route::get('/seekhelp/posts',[PostController::class,'get_posts_by_queries']);


Route::get('/stripe', [StripePaymentController::class,'stripe']);
Route::post('/stripe', [StripePaymentController::class,'stripe_post']);
