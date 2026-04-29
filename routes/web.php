<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     Route::get('/', fn()=>redirect()->route('login'));
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', fn()=>redirect()->route('tasks.index'))->name('dashboard');
    //Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::resource('tasks', TaskController::class);//->except(['index'])  ;
    Route::patch('tasks/{task}/status',[TaskController::class,'updateStatus'])
       ->name('tasks.status');
});




require __DIR__.'/auth.php';
