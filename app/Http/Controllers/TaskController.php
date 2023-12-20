<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignMemberRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\MoveTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Controllers\NotificationController;
use App\Models\TaskStatus;

class TaskController extends Controller
{  
    public function show(string $id): View
    {
        $task = Task::findOrFail($id);

        $this->authorize('show', $task);
        return view('pages.task', [
            'task' => $task,
            'main' => true
        ]);
    }
    

    public function create(CreateTaskRequest $request):RedirectResponse {

        $fields = $request->validated();

        $task = Task::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'status' => $fields['status'],
            'due_at' => $fields['due_at'],
            'effort' => $fields['effort'],
            'priority' => $fields['priority'],
            'project_id' => $fields['project_id']
        ]);
        
        NotificationController::TaskNotification($task,$fields['project_id'],'Created');
        
        return redirect()->route('projects.show', ['id' => $fields['project_id']])->withSuccess('New Task created!');
    }

    public function edit(EditTaskRequest $request, string $id): RedirectResponse
    {

        $fields = $request->validated();

        $task = Task::findOrFail($id);
        $this->authorize('edit', $task);

        $task->title = $fields['title'];
        $task->description = $fields['description'];
        $task->status = $fields['status'];
        if ($task->due_at != $fields['due_at']) $task->is_notified = false;
        $task->due_at = $fields['due_at'];
        $task->effort = $fields['effort'];
        $task->priority = $fields['priority'];
        
        $task->save();
        NotificationController::TaskNotification($task,$task->project_id,'Edited');
        return redirect()->back()->withSuccess('Task edited');
    }

    public function move(MoveTaskRequest $request, string $id): JsonResponse
    {
        $fields = $request->validated();

        $task = Task::findOrFail($id);
        $task->status = $fields['status'];

        $task->save();

        return response()->json([
            'status' => $fields['status']
        ]);
    }

    public function assignMember(AssignMemberRequest $request, string $task_id, string $username): JsonResponse
    {
        $request->validated();

        $task = Task::findOrFail($task_id);
        $member = User::where('username', $username)->first()->persistentUser->member;
        
        
        $this->authorize('assignMember', $task);

        try {
            $member->tasks()->attach($task_id);
            NotificationController::TaskNotification($task,$task->project_id,' assigned to member '.$username);
            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'picture' => $member->getProfileImage(),
                'is_leader' => false,
                'can_remove' => false,
                'can_move' => false,
                'task' => true
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

    public function complete(string $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        $this->authorize('edit', $task);

        $task->status = TaskStatus::Done->value;

        $task->save();
        NotificationController::TaskNotification($task,$task->project_id,'Completed');
        return redirect()->back()->withSuccess('Task completed');
    }

    public function comment(CommentRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        TaskComment::create([
            'content' => $fields['text'],
            'task_id' => $id,
            'member_id' => $fields['member']
        ]);

        return redirect()->route('tasks.show', ['id' => $id, '#comments'])->withSuccess('Comment added.');
    }

    public function delete(DeleteTaskRequest $deleteTaskRequest): RedirectResponse
    {
        $fields = $deleteTaskRequest->validated();
        $task = Task::findOrFail($fields['id']);

        $task->delete();
        return redirect()->route('projects.show', ['id' => $task->project_id])->withSuccess('Task deleted.');
    }
}
