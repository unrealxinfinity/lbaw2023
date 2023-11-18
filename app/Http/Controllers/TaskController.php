<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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

    public function assignMember(Request $request, string $task_id, string $member_id): void
    {
        // em cima eu faço project_id, bastava fazer isto?
        $fields = $request->validate([
            'type' => [Rule::in('Member', 'Project Leader')]
        ]);

        $task = Task::findOrFail($task_id);
        $member = Member::findOrFail($member_id);

        $this->authorize('assignMember', $task);

        $is_admin = $member->worlds->where('id', $task->world_id)[0]->pivot->is_admin;
        
        $member->tasks->attach($task_id, 'assignee');
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
