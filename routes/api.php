<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;



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
Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{id}',[PostController::class,'show']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);


Route::get('/posts/{id}/comments',[CommentController::class,'index']);
Route::get('/posts/{id}/comments/{id2}',[CommentController::class,'show']);









Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('/posts',[PostController::class,'store']);
    Route::put('/posts/{id}',[PostController::class,'update']);
    Route::delete('/posts/{id}',[PostController::class,'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);


    Route::delete('/posts/{id}/comments/{id2}',[CommentController::class,'destroy']);
    Route::put('/posts/{id}/comments/{id2}',[CommentController::class,'update']);
    Route::post('/posts/{id}/comments',[CommentController::class,'store']);


});
