<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('pages.home');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth'])->name('pages.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('sections', SectionController::class);
        Route::patch('/sections/{section}/toggle-visibility', [SectionController::class, 'toggleVisibility'])->name('sections.toggle-visibility');
        Route::patch('/sections/{section}/change-order', [SectionController::class, 'changeOrder'])->name('sections.change-order');
        Route::resource('plans', PlanController::class);
    });

require __DIR__ . '/auth.php';