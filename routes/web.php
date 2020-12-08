<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoneTaskController;
use App\Http\Controllers\NoteController;
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
    Route::get('tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
    Route::post('tasks/{task}/done', DoneTaskController::class)->name('tasks.done');

    Route::resource('tasks.notes', NoteController::class)
        ->only(['store', 'destroy']);
//    Route::group([
//        'prefix' => 'tasks/{task}'
//        ], function () {
//        Route::resource('notes',NoteController::class)
//            ->only(['store','destroy']);
//    });
});
