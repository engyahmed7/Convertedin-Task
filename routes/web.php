<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\StatisticsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web', 'verified'])->name('dashboard');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/tasks', [AdminTaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('/admin/tasks/create', [AdminTaskController::class, 'create'])->name('tasks.create');
    Route::post('/admin/tasks', [AdminTaskController::class, 'store'])->name('tasks.store');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
