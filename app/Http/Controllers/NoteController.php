<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(CreateNoteRequest $request, Task $task)
    {
        $task->notes()->create($request->validated());
        return redirect()->route('tasks.show', $task);
    }

    public function show(Note $note)
    {
        //
    }

    public function edit(Note $note)
    {
        //
    }

    public function update(Request $request, Note $note)
    {
        //
    }

    public function destroy(Task $task, Note $note)
    {
        $note->delete();
        return redirect()->route('tasks.show', $task);
    }
}
