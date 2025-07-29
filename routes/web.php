<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Use correct namespaces for API controllers
use App\Http\Controllers\Api\DailyLogController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\HabitController;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\SleepLogController;
use App\Http\Controllers\Api\WaterIntakeController;
use App\Http\Controllers\Api\TaskController;
use App\Models\Task;

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
        //$tasks = Task::where('user_id', auth()->id())->get();

        return Inertia::render('Dashboard', [
            // 'tasks' => $tasks,
        ]);
    })->name('dashboard');

    Route::get('/meals', function () {
        return Inertia::render('Meals');
    })->name('meals');

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

    // Tasks
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});
