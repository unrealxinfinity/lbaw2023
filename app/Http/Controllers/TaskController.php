<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    //
    public function create(Request $request) : RedirectResponse{
        $fields = $request->validate([
            'title' => ['alpha_num:ascii'],
            'description' => ['string'],
            'status' => ['string'],
            'due_at' => ['date'],
            'effort' => ['integer'],
            'priority' => ['string'],
            'project_id' => ['exists:App\Models\Project,id', Rule::in(auth()->user()->projects->pluck('id'))]
        ]);

        $task = Task::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'status' => $fields['status'],
            'project_id' => $fields['project_id']
        ]);

        return redirect()->route('tasks/' . $task->id)->withSuccess('New Task created!');
    }
}
