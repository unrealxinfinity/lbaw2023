<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignMemberRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\TaskCommentRequest;
use App\Models\Task;
use App\Models\TaskComment;
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

    public function edit(Request $request, string $id): RedirectResponse
    {

        $fields = $request->validate([
            'title' => ['string'],
            'description' => ['string'],
            'status' => [Rule::in('BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done')],
            'due_at' => ['date', 'after:today'],
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

        return redirect()->back()->withSuccess('Task edited');
    }

    public function assignMember(AssignMemberRequest $request, string $task_id, string $username): JsonResponse
    {
        $request->validated();

        $task = Task::findOrFail($task_id);
        $member = User::where('username', $username)->first()->persistentUser->member;
        

        $this->authorize('assignMember', $task);

        try {
            $member->tasks()->attach($task_id);

            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'picture' => $member->picture
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'username' => $username,
                'parent' => 'project',
                'child' => 'task'
            ]);
        }
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

    public function comment(TaskCommentRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        TaskComment::create([
            'content' => $fields['text'],
            'task_id' => $id,
            'member_id' => $fields['member']
        ]);

        return redirect()->route('tasks.show', ['id' => $id, '#comments'])->withSuccess('Comment added.');
    }
}
