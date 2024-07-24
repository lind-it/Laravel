<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

Route::get('/', [MainController::class, 'index']);

//определяем маршруты для постов
Route::get('/post/show/{id}', [PostController::class, 'show']);
Route::get('post/postList', [PostController::class, 'postList'])->middleware('custom_auth');
Route::get('/post/create', [PostController::class, 'create'])->middleware('custom_auth');
Route::post('/post/create', [PostController::class, 'create'])->middleware('custom_auth');
Route::get('/post/update/{id}', [PostController::class, 'update'])->middleware('custom_auth');
Route::put('/post/update/{id}', [PostController::class, 'update'])->middleware('custom_auth');
Route::get('/post/delete/{id}', [PostController::class, 'delete'])->middleware('custom_auth');

//определяем маршруты регистрации
Route::get('/user/register', [UserController::class, 'register']);
Route::post('/user/register', [UserController::class, 'register']);
Route::get('/user/auth', [UserController::class, 'auth']);
Route::post('/user/auth', [UserController::class, 'auth']);
Route::get('/user/profile', [UserController::class, 'profile']);
Route::get('/user/exit', [UserController::class, 'exit']);

//определяем маршруты для комментариев
Route::get('comment/get/{id}', [CommentController::class, 'get']);
Route::post('comment/create', [CommentController::class, 'create'])->middleware('custom_auth');
Route::put('comment/update', [CommentController::class, 'update'])->middleware('custom_auth');
Route::delete('comment/delete', [CommentController::class, 'delete'])->middleware('custom_auth');

//определяем маршруты для лайков
Route::post('like/create', [LikeController::class, 'create'])->middleware('custom_auth');
Route::delete('like/delete', [LikeController::class, 'delete'])->middleware('custom_auth');
