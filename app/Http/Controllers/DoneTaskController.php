<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DoneTaskController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function __invoke(Request $request, Task $task)
    {
        $task->update([
            'done' => !$task->done,
        ]);
        return response()->json([
            'success' => true,
            'data' => $task->toArray(),
        ]);
    }
}
