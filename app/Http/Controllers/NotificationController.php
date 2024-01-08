<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\World;
use App\Events\CreateProjectNotification;
use App\Events\CreateTagNotification;
use App\Events\CreateTaskNotification;
use App\Events\ WorldNotification;
use App\Models\Task;
use App\Models\User;
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
            'message'=>'Nothing Here',
            'id' => $id
        ]);
    }

    public function acceptRequest(string $id): JsonResponse {
        $request = Notification::findOrFail($id);
        $member = auth()->user()->persistentUser->member;
        $recipient = Member::findOrFail($request->member_id);
        
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
        $recipient->friends()->attach($member->id);
        $member->notifications()->detach($request);

        return response()->json([
            'error' => 'false',
            'message' => 'Friend request accepted!',
            'id' => $id
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
            $message = $action.' project '."'".$project->name."'".'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => $level,
                'world_id' => $world_id,
                'project_id' => null,
                'task_id' => null,
                'member_id' => null,
            ]);
             foreach($project->members as $member){
                $member->notifications()->attach($notification->id);
             } 
            DB::commit();
            event(new CreateProjectNotification($message,$world_id));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
   
    static function TaskNotification(Task $task,string $project_id, string $action){
        $project = Project::find($project_id);
        DB::beginTransaction();
        try {
            
            if($action == 'Completed' || $action == 'Created'){
                $level='High';
            }
            else{
                $level='Medium';
            }
            $message = $action.' task '."'".$task->title."'".'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => $level,
                'world_id' => null,
                'project_id' => $project_id,
                'task_id' => null,
                'member_id' => null,
            ]);
            foreach($project->members as $member){
                $member->notifications()->attach($notification->id);
             } 
            DB::commit();
            event(new CreateTaskNotification($message,$project_id));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    static function TagNotification(Tag $tag,string $idOrUname,string $type, string $action){
        if($type == 'Project'){
            $thing = Project::find($idOrUname);
            $message = $action.' tag '."'".$tag->name."'"." on Project ".$thing->name.' !';
            DB::beginTransaction();
            try {
                $notification = Notification::create([
                    'text' => $message,
                    'level' => 'Low',
                    'world_id' => null,
                    'project_id' => $idOrUname,
                    'task_id' => null,
                    'member_id' => null,
                ]);
                foreach($thing->members as $member){
                    $member->notifications()->attach($notification->id);
                    error_log($member->notifications()->get());
                 }
                DB::commit();
                event(new CreateTagNotification($message,$idOrUname,$type));
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }
        else if($type == 'World'){
            $thing = World::find($idOrUname);
            $message = $action.' tag '."'".$tag->name."'"." on World ".$thing->name.' !';
            DB::beginTransaction();
            try {
                $notification = Notification::create([
                    'text' => $message,
                    'level' => 'Low',
                    'world_id' => $idOrUname,
                    'project_id' => null,
                    'task_id' => null,
                    'member_id' => null,
                ]);
                foreach($thing->members as $member){
                    $member->notifications()->attach($notification->id);
                 }
                DB::commit();
                event(new CreateTagNotification($message,$idOrUname,$type));
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }
        else if($type == 'Member'){
            $thing = Member::where('name',$idOrUname)->first();
            $message = $action.' tag '."'".$tag->name."'"." on ".$thing->name."'s profile!";
            DB::beginTransaction();
            try {
                $notification = Notification::create([
                    'text' => $message,
                    'level' => 'Low',
                    'world_id' => null,
                    'project_id' => null,
                    'task_id' => null,
                    'member_id' => $thing->id,
                ]);
                $thing->notifications()->attach($notification->id);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        }       
    }

    static function WorldNotification(World $world, string $action){
        if(str_contains($action, 'promoted in') || str_contains($action, 'demoted in') || str_contains($action,'deleted')) {
            $level='High';
        }
        elseif(str_contains($action, 'created')){
            $level='Low';
        }
        else{
            $level='Medium';
        }
        
        DB::beginTransaction();
        try {
            $message = $action.' world '."'".$world->name."'".'!';
            $notification = Notification::create([
                'text' => $message,
                'level' => $level,
                'world_id' => str_contains($action, 'deleted')? null: $world->id,
                'project_id' => null,
                'task_id' => null,
            ]);
            
            foreach($world->members as $member){
                $member->notifications()->attach($notification->id);
             }
            DB::commit();
            event(new CreateWorldNotification($message,$world->id));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    static function InviteToWorldNotification($inviter,$member,$world){
        $message = "$inviter->name invited you to join the world $world->name !";
        $notification = Notification::create([
            'text' => $message,
            'level' => 'Medium',
            'world_id' => null,
            'project_id' => null,
            'task_id' => null,
            'member_id' => $member->id,
        ]);
        $member->notifications()->attach($notification->id);
    }

    function friendRequest(string $username): JsonResponse
    {
        $user = Auth::user();
        $message = "$user->username wants to be your friend!";

        $recipient = User::where('username', $username)->firstOrFail()->persistentUser->member;

        $notification = Notification::create([
            'text' => $message,
            'level' => 'Medium',
            'member_id' => $user->persistentUser->member->id,
            'is_request' => true
        ]);

        $recipient->notifications()->attach($notification->id);

        return response()->json([
            'message' => 'Friend request sent!'
        ]);
    }

    
    
}
