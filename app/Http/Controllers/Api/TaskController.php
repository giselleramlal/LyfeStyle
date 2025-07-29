<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::where('user_id', auth()->id())->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'text' => $task->description,  // map description to text
                'completed' => (bool) $task->is_completed,
            ];
        });

        return response()->json($tasks);
    }


    public function store(Request $request)
    {
        $request->validate(['text' => 'required|string|max:255']);

        $task = Task::create([
            'user_id' => auth()->id(),
            'description' => $request->text,
            'is_completed' => false,
        ]);

        return response()->json([
            'id' => $task->id,
            'text' => $task->description,
            'completed' => (bool) $task->is_completed,
        ]);
    }


    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->update([
            'is_completed' => $request->completed,
        ]);

        return response()->json(['message' => 'Task updated.']);
    }


    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted.']);
    }
}
