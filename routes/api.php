<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DailyLogController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\HabitController;
use App\Http\Controllers\Api\WorkoutController;
use App\Http\Controllers\Api\SleepLogController;
use App\Http\Controllers\Api\WaterIntakeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Add your API resource routes here (optionally protected by middleware)
Route::apiResource('daily-logs', DailyLogController::class);
Route::apiResource('meals', MealController::class);
Route::apiResource('habits', HabitController::class);
Route::apiResource('workouts', WorkoutController::class);
Route::apiResource('sleep-logs', SleepLogController::class);
Route::apiResource('water-intake', WaterIntakeController::class);
