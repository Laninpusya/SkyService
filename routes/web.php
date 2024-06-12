<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('user', \App\Http\Controllers\UserController::class)->only(['index', 'create', 'edit', 'update']);
Route::post('user/save',[App\Http\Controllers\UserController::class, 'save'])->name('user.save');
Route::delete('user/{id}', 'App\Http\Controllers\UserController@destroy')->name('user.destroy');

Route::resource('post', \App\Http\Controllers\PostController::class)->only(['index', 'create', 'edit', 'update']);
Route::post('post/save',[App\Http\Controllers\PostController::class, 'save'])->name('post.save');
Route::delete('post/{id}', 'App\Http\Controllers\PostController@destroy')->name('post.destroy');

Route::resource('comment', \App\Http\Controllers\CommentController::class)->only(['index', 'create', 'edit', 'update']);
Route::post('comment/save',[App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::delete('comment/{id}', 'App\Http\Controllers\CommentController@destroy')->name('comment.destroy');

//Route::any('/api', [ApiController::class, 'handle']);
Route::get('/api', [ApiController::class, 'handle']);
Route::post('/api', [ApiController::class, 'handle']);
