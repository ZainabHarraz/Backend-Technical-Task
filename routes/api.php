<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('posts', [PostController::class,'index']);
Route::get('posts/{id}', [PostController::class,'show']);  
Route::get('stats', [PostController::class,'stats']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('user-posts', [PostController::class,'userPosts']);
    Route::post('/store', [PostController::class, 'store']);        
    Route::put('/update/{id}', [PostController::class, 'update']);  
    Route::delete('/delete/{id}', [PostController::class, 'destroy']); 

});
