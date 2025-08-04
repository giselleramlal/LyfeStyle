<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WaterIntake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WaterIntakeController extends Controller
{
    public function index()
    {
        $entries = WaterIntake::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();
            
        return response()->json(['water_intake_entries' => $entries]);
    }

    public function getTodaysIntake(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        $waterIntake = WaterIntake::where('user_id', auth()->id())
            ->where('date', $date)
            ->first();
            
        return response()->json(['water_intake' => $waterIntake]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'glasses' => 'required|integer|min:0|max:8',
            'date' => 'required|date',
        ]);

        $existing = WaterIntake::where('user_id', auth()->id())
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existing) {
            $existing->update(['glasses' => $validated['glasses']]);
            return redirect()->back()->with('id', $existing->id); // ✅ Inertia-compatible
        }

        $new = WaterIntake::create([
            'user_id' => auth()->id(),
            'glasses' => $validated['glasses'],
            'date' => $validated['date'],
        ]);

        return redirect()->back()->with('id', $new->id); // ✅ Inertia-compatible
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'glasses' => 'required|integer|min:0|max:20',
            'date' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $waterIntake = WaterIntake::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $waterIntake->update($request->only(['glasses', 'date']));

        return response()->json([
            'message' => 'Water intake updated successfully',
            'water_intake' => $waterIntake
        ]);
    }

    public function destroy($id)
    {
        $waterIntake = WaterIntake::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $waterIntake->delete();

        return response()->json([
            'message' => 'Water intake deleted successfully'
        ]);
    }
}