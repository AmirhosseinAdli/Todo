<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoneTaskController;
use App\Http\Controllers\NoteActionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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
    Route::resource('users', UserController::class)
        ->middleware('can:admin');
});

Route::delete('tasks/{task}/notes/{note}/terminate', [NoteActionController::class, 'terminate'])->name('tasks.notes.terminate');
Route::post('tasks/{task}/notes/{note}/restore', [NoteActionController::class, 'restore'])->name('tasks.notes.restore');

Route::resource('tags', TagController::class);

Route::get('test', function () {
    $task = \App\Models\Task::find(1);
    return new \App\Mail\ReminderTaskMail($task);
});
