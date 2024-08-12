<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function($router){
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('loogout');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
Route::post('/me', [AuthController::class,'me'])->middleware('auth:api')->name('me');
});


//post related route
Route::middleware('auth:api')->group(function(){
    Route::post('post', [PostController::class, 'store']);
    Route::patch('post/{id}', [PostController::class, 'update']);
    Route::delete('post/{id}', [PostController::class,'destroy']);
});

//Public routes for viewing posts
Route::get('posts', [PostController::class, 'index']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
