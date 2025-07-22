<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkoutController extends Controller
{
    public function index()
    {
        $workouts = Workout::where('user_id', auth()->id())->get();
        return Inertia::render('Workouts/Index', ['workouts' => $workouts]);
    }

    public function store(Request $request)
    {
        Workout::create($request->merge(['user_id' => auth()->id()])->all());
        return redirect()->back()->with('success', 'Workout added.');
    }

    public function update(Request $request, $id)
    {
        Workout::where('user_id', auth()->id())->findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Workout updated.');
    }

    public function destroy($id)
    {
        Workout::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Workout deleted.');
    }
}
