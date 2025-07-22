<?php

namespace App\Http\Controllers\Api;

use App\Models\DailyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DailyLogController extends Controller
{
    public function index()
    {
        return DailyLog::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $dailyLog = DailyLog::updateOrCreate(
            ['user_id' => auth()->id(), 'date' => $request->date],
            $request->all()
        );
        return response()->json($dailyLog, 201);
    }

    public function update(Request $request, $id)
    {
        $dailyLog = DailyLog::where('user_id', auth()->id())->findOrFail($id);
        $dailyLog->update($request->all());
        return response()->json($dailyLog);
    }

    public function destroy($id)
    {
        DailyLog::where('user_id', auth()->id())->findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
