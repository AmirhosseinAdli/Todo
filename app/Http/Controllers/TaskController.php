<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Jobs\SendReminderEmailJob;
use App\Mail\ReminderTaskMail;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Task::class,'task');
    }

    public function index()
    {
        if (Gate::allows('admin')) {
            $tasks = Task::query()->latest()->paginate();
        } else {
            $tasks = auth()->user()->tasks()->latest()->get();
        }
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tags = auth()->user()->tags->pluck('name', 'id');
        return view('tasks.create', compact('tags'));
    }

    public function store(CreateTaskRequest $request)
    {


        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'done' => $request->get('done', false),
            'date' => Carbon::createFromTimestampMs($request->altField),
        ]);
        if ($request->has('tags')) {
            $task->tags()->sync($request->get('tags'));
        }
//        Mail::to(auth()->user()->email)->send(new ReminderTaskMail($task));
//        Mail::to(auth()->user()->email)->later($task->date,new ReminderTaskMail($task));
        SendReminderEmailJob::dispatch($task)->delay($task->date);
        return redirect()->route('tasks.index')->with('status', 'کار با موفقیت ساخته شد');
    }

    public function show(Task $task)
    {
        if (!Gate::allows('view-task', $task))
            return abort(404);
        return view('tasks.show')->withTask($task);
    }

    public function edit(Task $task)
    {
        $tags = auth()->user()->tags->pluck('name', 'id');
        return view('tasks.edit', compact('task', 'tags'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        if ($request->has('tags')) {
            $task->tags()->sync($request->get('tags'));
        }
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
