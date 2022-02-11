<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $taskList = TaskList::query()->create([
            'name' => $request->name
        ]);

        return response()->json($taskList);
    }

    public function index(Request $request)
    {
        $taskLists = TaskList::query()->get();

        return response()->json($taskLists);
    }

    public function update(Request $request, TaskList $taskList)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string'
        ]);
        $taskList->update($validated);

        return response()->json($taskList);
    }

    public function show(TaskList $taskList)
    {
//        $taskList->load('tasks');
        //VS

        $tasks              = Task::query()->where('task_list_id', $taskList->id)->get();
        $taskList           = $taskList->toArray();
        $taskList['tasks']  = $tasks;

        return response()->json($taskList);
    }

    public function destroy(TaskList $taskList)
    {
        $taskList->delete();

        return response()->noContent();
    }
}
