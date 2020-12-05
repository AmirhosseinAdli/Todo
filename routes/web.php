<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('showRegister');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::get('login', [AuthController::class, 'showLogin']);
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::resource('tasks', TaskController::class);
});
