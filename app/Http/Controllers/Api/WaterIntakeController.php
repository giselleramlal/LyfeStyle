<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WaterIntake;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WaterIntakeController extends Controller
{
    public function index()
    {
        $entries = WaterIntake::where('user_id', auth()->id())->get();
        return Inertia::render('WaterIntake/Index', ['waterIntake' => $entries]);
    }

    public function store(Request $request)
    {
        WaterIntake::create($request->merge(['user_id' => auth()->id()])->all());
        return redirect()->back()->with('success', 'Water intake recorded.');
    }

    public function update(Request $request, $id)
    {
        WaterIntake::where('user_id', auth()->id())->findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Water intake updated.');
    }

    public function destroy($id)
    {
        WaterIntake::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Water intake deleted.');
    }
}
