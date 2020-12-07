<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks;
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(CreateTaskRequest $request)
    {
        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'done' => $request->get('done', false),
        ]);
        return redirect()->route('tasks.index')->with('status', 'کار با موفقیت ساخته شد');
    }

    public function show(Task $task)
    {
        if ($task->user_id == auth()->id())
            return $task;
        else
            return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('tasks.index')->with('status', "  $request->title با موفقیت ویرایش شد");
    }

    public function destroy(Task $task)
    {
        $Task = $task->title;
        $task->delete();
        return redirect()->route('tasks.index')->with('status', "کار $Task (با متد delete)با موفقیت حذف شد");
    }

    public function delete(Task $task)
    {
        $Task = $task->title;
        $task->delete();
        return redirect()->route('tasks.index')->with('status', "کار $Task (با متد get)با موفقیت حذف شد");
    }
}
