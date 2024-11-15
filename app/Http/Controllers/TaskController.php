<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignMemberRequest;
use App\Http\Requests\RemoveMemberFromTaskRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\MoveTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
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

        try {
            $member = User::where('username', $username)->first()->persistentUser->member;
            $member->tasks()->attach($task_id);
            $can_remove = $this->authorize('assignMember', $task);
            NotificationController::TaskNotification($task,$task->project_id,' assigned to member '.$username);
            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'task_id' => $task->id,
                'picture' => $member->getProfileImage(),
                'is_leader' => false,
                'can_remove' => $can_remove,
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

    public function removeMember(RemoveMemberFromTaskRequest $request, string $task_id, string $username): JsonResponse
    {
        $request->validated();

        $task = Task::findOrFail($task_id);
        $member = User::where('username', $username)->first()->persistentUser->member;
        error_log($username);

        try
        {
            $member->tasks()->detach($task_id);

            return response()->json([
                'error' => false,
                'id' => $task->id,
                'member_id' => $member->id,
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => true,
                'id' => $task->id,
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

    public function delete(string $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);

        $project_id = $task->project_id;

        $task->delete();
        return redirect()->route('projects.show', ['id' => $project_id])->withSuccess('Task deleted.');
    }
}
