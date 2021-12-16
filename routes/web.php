<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSocialiteController;

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

Route::get('/', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('callback/google/code=12207', [GoogleSocialiteController::class, 'handleCallback']);


Route::get('home', [GoogleSocialiteController::class, 'index']);
Route::post('todolist',[GoogleSocialiteController::class, 'todolist']);
Route::post('todos',[GoogleSocialiteController::class, 'todos']);
Route::post('comment',[GoogleSocialiteController::class, 'comment']);





