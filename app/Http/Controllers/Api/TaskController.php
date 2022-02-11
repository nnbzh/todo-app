<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title'         => 'required|string',
            'body'          => 'required|string',
            'status'        => 'required|boolean',
            'task_list_id'  => 'required|int|exists:task_lists,id',
        ]);
        $task = Task::query()->create($validated);

        return response()->json($task);
    }

    public function index(Request $request)
    {
        $tasks = Task::query()->get();

        return response()->json($tasks);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $this->validate($request, [
            'title'         => 'nullable|string',
            'body'          => 'nullable|string',
            'status'        => 'nullable|boolean',
            'task_list_id'  => 'nullable|int|exists:task_lists,id',
        ]);
        $task->update($validated);

        return response()->json($task);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
