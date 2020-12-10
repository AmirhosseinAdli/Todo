<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;

class NoteActionController extends Controller
{
    public function terminate(Task $task, $note)
    {
        Note::withTrashed()->find($note)->forceDelete();
        return $this->back($task, 'یادداشت با موفقیت حذف کامل شد ');
    }

    private function back(Task $task, $message = '')
    {
        return redirect()->route('tasks.show', $task)->with('status', $message);
    }

    public function restore(Task $task, $note)
    {
        Note::withTrashed()->find($note)->restore();
        return $this->back($task, 'یادداشت با موفقیت بازنشانی شد');
    }

}
