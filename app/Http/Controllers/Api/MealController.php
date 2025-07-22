<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::where('user_id', auth()->id())->get();
        return response()->json($meals);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
        ]);

        $meal = Meal::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Meal created successfully.',
            'meal' => $meal,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $meal = Meal::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
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
