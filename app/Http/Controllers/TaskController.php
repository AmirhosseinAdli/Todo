<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tags = auth()->user()->tags->pluck('name', 'id');
        return view('tasks.create', compact('tags'));
    }

    public function store(CreateTaskRequest $request)
    {
        /** @var $task Task */

        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'done' => $request->get('done', false),
            'date' => Carbon::createFromTimestampMs($request->altField),
        ]);
        if ($request->has('tags')) {
            $task->tags()->sync($request->get('tags'));
        }
        return redirect()->route('tasks.index')->with('status', 'کار با موفقیت ساخته شد');
    }

    public function show(Task $task)
    {
        if ($task->user_id == auth()->id())
            return view('tasks.show')->withTask($task);
        else
            return abort(404);
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
