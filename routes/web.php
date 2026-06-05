<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('student')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/tasks', [DashboardController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks/{task}/toggle', [DashboardController::class, 'toggleTask'])->name('tasks.toggle');
        Route::post('/schedules', [DashboardController::class, 'createSchedule'])->name('schedules.create');
        Route::post('/goals', [DashboardController::class, 'createGoal'])->name('goals.create');
        Route::post('/goals/{goal}/increment', [DashboardController::class, 'incrementGoal'])->name('goals.increment');
        Route::post('/pomodoro', [DashboardController::class, 'logPomodoro'])->name('pomodoro.log');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });
});

