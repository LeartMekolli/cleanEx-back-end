<?php

use App\Http\Controllers\PostController;
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
    Route::post('/createPost', [PostController::class, 'createPost']);
    Route::get('/getPosts', [PostController::class, 'getPosts']);
    Route::get('/getPost/{id}', [PostController::class, 'getPostById']);
    Route::get('/deletePost/{id}', [PostController::class, 'deletePostById']);
    Route::patch('/updatePost/{id}', [PostController::class, 'updatePostById']);
});