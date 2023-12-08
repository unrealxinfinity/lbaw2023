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
use App\Models\Project;
use App\Models\World;
use App\Events\CreateProjectNotification;
use App\Events\CreateTagNotification;
use App\Events\CreateTaskNotification;
use App\Events\CreateWorldNotification;
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
    public function clearNotifications():JsonResponse{
        $member = auth()->user()->persistentUser->member;
        $member->notifications()->detach();
        return response()->json([
            'message'=>'Nothing Here'
        ]);
    }

    public function clearSingle(string $id): JsonResponse {
        $member = auth()->user()->persistentUser->member;
        $member->notifications()->detach($id);
        return response()->json([
            'message'=>'Nothing Here'
        ]);
    }

    public function acceptRequest(string $id): JsonResponse {
        $request = Notification::findOrFail($id);
        $member = auth()->user()->persistentUser->member;
        
        if (!$request->is_request) {
            return response()->json([
                'error' => 'true',
                'message' => 'This notification is not a friend request!'
            ]);
        }

        if (!$member->notifications->contains('id', $id)) {
            return response()->json([
                'error' => 'true',
                'message' => 'This request does not belong to you!'
            ]);
        } 

        $member->friends()->attach($request->member_id);
        $member->notifications()->detach($request);

        return response()->json([
            'error' => 'false',
            'message' => 'Friend request accepted!'
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
            $message = $action.' Project '."'".$project->name."'".'!';
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
                event(new CreateProjectNotification($message,$world_id));
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
            $message = $action.' Task '."'".$task->title."'".'!';
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
            event(new CreateTaskNotification($message,$project_id));
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
            $message = $action.' Tag '."'".$tag->name."'".'!';
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
             event(new CreateTagNotification($message,$project_id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    static function WorldNotification(World $world, string $action){
        DB::beginTransaction();
        try {
            $message = $action.' World '."'".$world->name."'".'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => 'Medium',
                'world_id' => $world->id,
                'project_id' => null,
                'task_id' => null,
            ]);
            foreach($world->members as $member){
                $member->notifications()->attach($notification->id);
             }
             event(new CreateWorldNotification($message,$world->id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    
    
}
