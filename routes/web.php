<?php

use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebpostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('web.login.form');
Route::post('/login', [WebAuthController::class, 'login'])->name('web.login.submit');


Route::middleware('auth')->group(function () {

    Route::get('/home', [WebpostController::class, 'index'])->name('posts.index');
    Route::resource('posts', WebpostController::class)->except(['index']);
    
});
