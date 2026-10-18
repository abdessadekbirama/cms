<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Post as ControllersPost;
use App\Http\Controllers\PostController;
use App\Livewire\Dashboard;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
 
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
 
/*
|--------------------------------------------------------------------------
| Authenticated only
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
 
    // index, create, store, show, edit, update, destroy
    Route::resource('posts', PostController::class);
});