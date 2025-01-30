<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Registration Route
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Dashboard Route
Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// API Key Management Route
Route::middleware('auth')->post('/dashboard/api-keys', [AuthController::class, 'generateApiKey'])->name('api.keys');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// define all the auth routes (login, register, logout, etc.)
//Auth::routes();  // This will define routes for login, register, logout, etc.

// login goodness
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');