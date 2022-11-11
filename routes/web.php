<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

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
/*Route::get('/posts',function(){
    \App\Models\Post::create(
        [
            'user_id'=>1,
            'post_content'=>"Palestine is the best place in the world"

        ]);
    \App\Models\Post::create(
        [
            'user_id'=>2,
            'post_content'=>"America is the best place in the world"

        ]);
    \App\Models\Post::create(
        [
            'user_id'=>3,
            'post_content'=>"France is the best place in the world"

        ]);


});*/
/*Route::get('/users',function (){
    \App\Models\User::create(
      [
          'name'=>"Mohammad",
          'email'=>'mohammad@gmail.com',
          'password'=>bcrypt('123456')
      ]
    );
    \App\Models\User::create(
        [
            'name'=>"Talal",
            'email'=>'talal@gmail.com',
            'password'=>bcrypt('123456')
        ]
    );
    \App\Models\User::create(
        [
            'name'=>"Azzam",
            'email'=>'azzam@gmail.com',
            'password'=>bcrypt('123456')
        ]
    );
});
Route::get('/posts',function (){
    \App\Models\Post::create(
        [
            'user_id'=>1,
            'post_content'=>'Palestine is the best place in the world',
        ]
    );
        \App\Models\Post::create(
            [
                'user_id'=>1,
                'post_content'=>'Palestine is the wonderful place in the world',
            ]
        );
    \App\Models\Post::create(
        [
            'user_id'=>2,
            'post_content'=>'America is the wonderful place in the world',
        ]
    );
});
Route::get('/comments',function (){
    \App\Models\Comment::create(
        [
            'user_id'=>2,
            'post_id'=>1,
            'comment_content'=>'true',
        ]
    );
    \App\Models\Comment::create(
        [
            'user_id'=>3,
            'post_id'=>1,
            'comment_content'=>'100%',
        ]
    );
    \App\Models\Comment::create(
        [
            'user_id'=>1,
            'post_id'=>1,
            'comment_content'=>'definatly true',
        ]
    );
    \App\Models\Comment::create(
        [
            'user_id'=>1,
            'post_id'=>3,
            'comment_content'=>'no man',
        ]
    );
});*/
