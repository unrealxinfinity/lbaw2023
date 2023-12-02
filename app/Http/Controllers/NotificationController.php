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
use App\Events\CreateTag;
use App\Models\Task;
use App\Models\Tag;

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

    static function ProjectNotification(Project $project,string $world_id, string $action){
        
        DB::beginTransaction();
        try {
            $level='';
            if($action == 'Created'){
                $level='Low';
            }
            elseif($action == 'Deleted'){
                $level='High';
            }
            else{
                $level='Medium';
            }
            $message = $action.' Project '.$project->name.'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => $level,
                'world_id' => $world_id,
                'project_id' => null,
                'task_id' => null,
            ]);
             foreach($project->members as $member){
                $member->notifications()->attach($notification->id);
             } 
                event(new CreateProject($message,$world_id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
   
    static function TaskNotification(Task $task,string $project_id, string $action){
        $project = Project::find($project_id);
        DB::beginTransaction();
        try {
            if($action == 'Created'){
                $level='Low';
            }
            elseif($action == 'Completed'){
                $level='High';
            }
            else{
                $level='Medium';
            }
            $message = $action.' Task '.$task->title.'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => $level,
                'world_id' => null,
                'project_id' => $project_id,
                'task_id' => null,
            ]);
            foreach($project->members as $member){
                $member->notifications()->attach($notification->id);
             } 
            event(new CreateTask($task->title,$project_id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    static function TagNotification(Tag $tag,string $project_id, string $action){
        $project = Project::find($project_id);
        DB::beginTransaction();
        try {
            $message = $action.' Tag '.$tag->name.'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => 'Low',
                'world_id' => null,
                'project_id' => $project_id,
                'task_id' => null,
            ]);
            foreach($project->members as $member){
                $member->notifications()->attach($notification->id);
             }
             event(new CreateTag($tag->name,$project_id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    
    
}
