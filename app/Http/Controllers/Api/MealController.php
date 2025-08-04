<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::forUser()->orderBy('created_at', 'desc')->get();
        
        return Inertia::render('Meals/Index', [
            'meals' => $meals
        ]);
    }

    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return back()->withErrors(['error' => 'You must be logged in to add meals.']);
        }

        $validated = $request->validate([
            'type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'description' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0|max:9999',
            'protein' => 'nullable|numeric|min:0|max:999',
            'carbs' => 'nullable|numeric|min:0|max:999',
            'fat' => 'nullable|numeric|min:0|max:999',
            'daily_log_id' => 'nullable|integer', // Made nullable since daily_logs might not exist
        ]);

        $meal = Meal::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'description' => $validated['description'],
            'calories' => $validated['calories'],
            'protein' => $validated['protein'],
            'carbs' => $validated['carbs'],
            'fat' => $validated['fat'],
            'daily_log_id' => $validated['daily_log_id'] ?? null,
        ]);

        return back()->with('success', 'Meal added successfully!');
    }

    public function show(Meal $meal)
    {
        
        return Inertia::render('Meals/Show', [
            'meal' => $meal
        ]);
    }

    public function edit(Meal $meal)
    {
        
        return Inertia::render('Meals/Edit', [
            'meal' => $meal
        ]);
    }

    public function update(Request $request, Meal $meal)
    {

        $validated = $request->validate([
            'type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'description' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0|max:9999',
            'protein' => 'nullable|numeric|min:0|max:999',
            'carbs' => 'nullable|numeric|min:0|max:999',
            'fat' => 'nullable|numeric|min:0|max:999',
            'daily_log_id' => 'nullable|integer',
        ]);

        $meal->update($validated);

        return redirect()->back()->with('success', 'Meal updated successfully!');
    }

    public function destroy(Meal $meal)
    {
        
        $meal->delete();

        return redirect()->back()->with('success', 'Meal deleted successfully!');
    }

    // API endpoint for getting meals by type
    public function byType(Request $request)
    {
        $type = $request->get('type');
        $meals = Meal::forUser()->byType($type)->get();
        
        return response()->json($meals);
    }

    // API endpoint for nutrition stats
    public function stats(Request $request)
    {
        $days = $request->get('days', 7);
        $startDate = now()->subDays($days);
        
        $meals = Meal::forUser()
            ->where('created_at', '>=', $startDate)
            ->get();
            
        $stats = [
            'total_meals' => $meals->count(),
            'total_calories' => $meals->sum('calories'),
            'total_protein' => $meals->sum('protein'),
            'total_carbs' => $meals->sum('carbs'),
            'total_fat' => $meals->sum('fat'),
            'avg_calories_per_meal' => $meals->avg('calories'),
        ];
        
        return response()->json($stats);
    }

    public function apiIndex()
    {
        $meals = Meal::forUser()->orderBy('created_at', 'desc')->get();
        return response()->json($meals);
    }
}