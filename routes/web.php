<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Show the user form
Route::get('/users', [UserController::class, 'showForm'])->name('users.form');

// Store user data
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Get users list (can use for AJAX)
Route::get('/users/list', [UserController::class, 'index'])->name('users.index');

Route::post('/users', [UserController::class, 'store'])->name('users.store');