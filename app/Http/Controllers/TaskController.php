<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignMemberRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{  
    public function show(string $id): View
    {
        $task = Task::findOrFail($id);

        //$this->authorize('show', $task);
        return view('pages.task', [
            'task' => $task,
            'main' => true
        ]);
    }
    
    //
    public function create(CreateTaskRequest $request) : RedirectResponse{

        $fields = $request->validated();

        Task::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'status' => $fields['status'],
            'due_at' => $fields['due_at'],
            'effort' => $fields['effort'],
            'priority' => $fields['priority'],
            'project_id' => $fields['project_id']
        ]);

        return redirect()->route('projects.show', ['id' => $fields['project_id']])->withSuccess('New Task created!');
    }

    public function edit(Request $request, string $id): void
    {

        $fields = $request->validate([
            'title' => ['alpha_num:ascii'],
            'description' => ['string'],
            'status' => [Rule::in('BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done')],
            'due_at' => ['date'],
            'effort' => ['integer'],
            'priority' => ['string'],
        ]);

        $task = Task::findOrFail($id);
        $this->authorize('edit', $task);

        $task->title = $fields['title'];
        $task->description = $fields['description'];
        $task->status = $fields['status'];
        $task->due_at = $fields['due_at'];
        $task->effort = $fields['effort'];
        $task->priority = $fields['priority'];

        $task->save();
    }

    public function assignMember(AssignMemberRequest $request, string $task_id, string $username): JsonResponse
    {
        $request->validated();

        $task = Task::findOrFail($task_id);
        $member = User::where('username', $username)->first()->persistentUser->member;
        

        $this->authorize('assignMember', $task);

        $member->tasks()->attach($task_id);
        
        return response()->json([
            'id' => $member->id,
            'username' => $username,
            'email' => $member->email,
            'description' => $member->description
        ]);
    }

    public function complete(string $id): View
    {
        $task = Task::findOrFail($id);
        $this->authorize('edit', $task);

        $task->status = 'Done';

        $task->save();

        return view('pages.task', [
            'task' => $task,
            'main' => true
        ]);
    }
}
