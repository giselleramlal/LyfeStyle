<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SleepLog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class SleepLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SleepLog::forUser()
            ->orderBy('date', 'desc')
            ->orderBy('sleep_time', 'desc');
            
        // Add date filtering if provided
        if ($request->has('start_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }
        
        $sleepLogs = $query->paginate(15);
        
        return Inertia::render('SleepLogs/Index', [
            'sleepLogs' => $sleepLogs,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'sleep_time' => 'required|date_format:H:i',
            'wake_time' => 'required|date_format:H:i',
            'quality' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string|max:1000',
            'daily_log_id' => 'nullable|exists:daily_logs,id'
        ]);

        // Check for duplicate entries on the same date
        $existing = SleepLog::forUser()
            ->where('date', $validated['date'])
            ->first();
            
        if ($existing) {
            return back()->withErrors([
                'date' => 'A sleep log already exists for this date.'
            ]);
        }

        $sleepLog = SleepLog::create(array_merge($validated, [
            'user_id' => auth()->id()
        ]));

        return back()->with('success', 'Sleep log added successfully!');
    }

    public function show(SleepLog $sleepLog)
    {
        $this->authorize('view', $sleepLog);
        
        return Inertia::render('SleepLogs/Show', [
            'sleepLog' => $sleepLog
        ]);
    }

    public function edit(SleepLog $sleepLog)
    {
        $this->authorize('update', $sleepLog);
        
        return Inertia::render('SleepLogs/Edit', [
            'sleepLog' => $sleepLog
        ]);
    }

    public function update(Request $request, SleepLog $sleepLog)
    {
        $this->authorize('update', $sleepLog);
        
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'sleep_time' => 'required|date_format:H:i',
            'wake_time' => 'required|date_format:H:i',
            'quality' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string|max:1000',
            'daily_log_id' => 'nullable|exists:daily_logs,id'
        ]);

        // Check for duplicate entries on the same date (excluding current record)
        $existing = SleepLog::forUser()
            ->where('date', $validated['date'])
            ->where('id', '!=', $sleepLog->id)
            ->first();
            
        if ($existing) {
            return back()->withErrors([
                'date' => 'A sleep log already exists for this date.'
            ]);
        }

        $sleepLog->update($validated);

        return back()->with('success', 'Sleep log updated successfully!');
    }

    public function destroy(SleepLog $sleepLog)
    {
        $this->authorize('delete', $sleepLog);
        
        $sleepLog->delete();

        return back()->with('success', 'Sleep log deleted successfully!');
    }

    // API endpoint for statistics
    public function stats(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = Carbon::now()->subDays($days);
        
        $logs = SleepLog::forUser()
            ->where('date', '>=', $startDate)
            ->get();
            
        $stats = [
            'total_logs' => $logs->count(),
            'average_duration' => $logs->avg('duration_hours'),
            'average_quality' => $logs->avg('quality'),
            'total_sleep_time' => $logs->sum('duration_hours'),
            'best_quality_day' => $logs->where('quality', $logs->max('quality'))->first(),
            'longest_sleep' => $logs->sortByDesc('duration_hours')->first(),
        ];
        
        return response()->json($stats);
    }
}