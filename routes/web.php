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
    Route::resource('meals', App\Http\Controllers\Api\MealController::class);
    Route::get('meals/stats', [App\Http\Controllers\Api\MealController::class, 'stats'])->name('meals.stats');
    Route::get('/api/meals', [MealController::class, 'apiIndex']);

    // Habits
    Route::resource('habits', HabitController::class)->except(['create', 'edit']);

    // Workouts
    Route::resource('workouts', WorkoutController::class)->except(['create', 'edit']);

    // Sleep Logs
    Route::resource('sleep-logs', SleepLogController::class);
    Route::get('sleep-logs/stats', [SleepLogController::class, 'stats'])->name('sleep-logs.stats');

    Route::get('/water-intake', [WaterIntakeController::class, 'index']);
    Route::get('/water-intake/today', [WaterIntakeController::class, 'getTodaysIntake']);
    Route::resource('/water-intake', WaterIntakeController::class);
    Route::put('/water-intake/{id}', [WaterIntakeController::class, 'update'])->name('water-intake.update');
    Route::delete('/water-intake/{id}', [WaterIntakeController::class, 'destroy']);

    // Tasks
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::resource('/tasks', TaskController::class);
    Route::patch('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});