<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNotificationRequest;
use App\Models\Notification;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Events\CreateWorld;
use App\Models\Project;
use App\Events\CreateProject;
use App\Models\Task;

class NotificationController extends Controller
{
    public function listNotifications():JsonResponse{
        $member_id= auth()->user()->persistentUser->member->id;
        $notifications = Member::find($member_id)->notifications;
        $notificationsJson = $notifications->toJson();
        return response()->json([
            'error' => false,
            'notifications' => $notifications
        ]);

    }

    static function createProjectNotification(Project $project,$world_id){
        $member = Member::where('user_id', auth()->user()->id)->first();
        DB::beginTransaction();
        try {
            $message = 'Created Project '.$project->name.'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => 'Low',
                'world_id' => $world_id,
                'project_id' => null,
                'task_id' => null,
            ]);
             $member->notifications()->attach($notification->id);
                event(new CreateProject($message,$world_id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    static function createTaskNotification(Task $task,$project_id){
        $member = Member::where('user_id', auth()->user()->id)->first();
        DB::beginTransaction();
        try {
            $message = 'Created Task '.$task->title.'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => 'Low',
                'world_id' => null,
                'project_id' => $project_id,
                'task_id' => null,
            ]);
             $member->notifications()->attach($notification->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
}
