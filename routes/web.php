<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::group([ 'middleware' => 'auth' ], function () {
    Route::get('/', [ WelcomeController::class, 'welcome' ])->name('home');

    Route::get('projects/create', [ ProjectController::class, 'create' ])->name('projects.create');
    Route::post('projects', [ ProjectController::class, 'store' ])->name('projects.store');
    Route::patch('projects/{project}', [ ProjectController::class, 'update' ])->name('projects.update');
    Route::get('projects/{project}', [ ProjectController::class, 'show' ])->name('projects.show');

    Route::post('projects/{project}/tasks', [ TaskController::class, 'asyncStore' ])->name('tasks.store');
    Route::patch('projects/{project}/tasks/prioritize', [ TaskController::class, 'asyncPrioritize' ])->name('tasks.prioritize');
    Route::patch('projects/{project}/tasks/{task}', [ TaskController::class, 'asyncUpdate' ])->name('tasks.update');
    Route::delete('projects/{project}/tasks/{task}', [ TaskController::class, 'asyncDestroy' ])->name('tasks.destroy');
});
