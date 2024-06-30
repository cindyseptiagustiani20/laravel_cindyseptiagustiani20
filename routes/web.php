<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/', AuthController::class);
Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])->name('auth');

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth']);

Route::get('/logout', [AuthController::class, 'logout']);
