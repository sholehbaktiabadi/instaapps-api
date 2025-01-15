<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// auth
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
Route::post('/register', RegisterController::class);


// posts
Route::apiResource('/posts', PostController::class)->middleware('auth:sanctum');
Route::apiResource('/posts/comments', PostCommentController::class)->middleware('auth:sanctum');
Route::apiResource('/posts/likes', PostLikeController::class)->middleware('auth:sanctum');