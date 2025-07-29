<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MealController extends Controller
{
    public function index()
    {
        return response()->json(Meal::all()); //filter by user_id eventually
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbs' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'daily_log_id' => 'required|integer',
        ]);

        $meal = Meal::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'description' => $validated['description'],
            'calories' => $validated['calories'],
            'protein' => $validated['protein'] ?? null,
            'carbs' => $validated['carbs'] ?? null,
            'fat' => $validated['fat'] ?? null,
            'daily_log_id' => $validated['daily_log_id'],
        ]);

        return response()->json([
            'meal' => $meal,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $meal = Meal::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string|max:255', // changed from name to description
            'calories' => 'required|numeric|min:0',
        ]);

        $meal->update($validated);

        return response()->json(['message' => 'Meal updated.', 'meal' => $meal]);
    }

    public function destroy($id)
    {
        $meal = Meal::where('user_id', auth()->id())->findOrFail($id);
        $meal->delete();

        return response()->json(['message' => 'Meal deleted.']);
    }
}
