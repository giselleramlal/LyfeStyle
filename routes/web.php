<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\SleepLogController;
use App\Http\Controllers\WaterIntakeController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Daily Logs
    Route::get('/daily-logs', [DailyLogController::class, 'index'])->name('daily-logs.index');
    Route::post('/daily-logs', [DailyLogController::class, 'store'])->name('daily-logs.store');
    Route::put('/daily-logs/{id}', [DailyLogController::class, 'update'])->name('daily-logs.update');
    Route::delete('/daily-logs/{id}', [DailyLogController::class, 'destroy'])->name('daily-logs.destroy');

    // Meals
    Route::resource('meals', MealController::class)->except(['create', 'edit']);

    // Habits
    Route::resource('habits', HabitController::class)->except(['create', 'edit']);

    // Workouts
    Route::resource('workouts', WorkoutController::class)->except(['create', 'edit']);

    // Sleep Logs
    Route::resource('sleep-logs', SleepLogController::class)->except(['create', 'edit']);

    // Water Intake
    Route::resource('water-intake', WaterIntakeController::class)->except(['create', 'edit']);
});
