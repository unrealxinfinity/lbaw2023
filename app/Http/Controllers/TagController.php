<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Tag;
use App\Models\Project;
use App\Http\Requests\CreateProjectTagRequest;
use App\Http\Requests\CreateWorldTagRequest;
use App\Http\Requests\CreateMemberTagRequest;
use App\Models\World;
use App\Models\Member;
use App\Http\Controllers\NotificationController;
class TagController extends Controller
{
    public function createProjectTag(CreateProjectTagRequest $request,string $project_id):JsonResponse{

        $fields = $request->validate(['tagName' => ['required', 'string', 'max:30']]);
        $tagName=strip_tags($fields['tagName']);
        $project = Project::find($project_id);
        if($project->tags()->where('name',$tagName)->exists()){
            return response()->json([
                'error' => true,
                'tagName'=> ''
            ]);
        }
        else{
            $tag = Tag::updateOrCreate([
                'name' => $tagName,
            ]);
            
        }
        $project->tags()->attach($tag->id);

        NotificationController::TagNotification($tag,$project_id,"Project",'Created');
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
    public function createWorldTag(CreateWorldTagRequest $request,string $id):JsonResponse{
        $fields = $request->validate(['tagName' => ['required', 'string', 'max:30']]);
        $tagName=strip_tags($fields['tagName']);
        $world = World::find($id);
        if($world->tags()->where('name',$tagName)->exists()){
            return response()->json([
                'error' => true,
                'tagName'=> ''
            ]);
        }
        else{
            $tag = Tag::updateOrCreate([
                'name' => $tagName,
            ]);
        }
        
        $world->tags()->attach($tag->id);
        
        NotificationController::TagNotification($tag,$id,"World",'Created');
        
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
   public function createMemberTag(CreateMemberTagRequest $request, string $username){
        $fields = $request->validate(['tagName' => ['required', 'string', 'max:30']]);
        $tagName=strip_tags($fields['tagName']);
        $member = Member::where('name',$username)->first();
        if($member->tags()->where('name',$tagName)->exists()){
            return response()->json([
                'error' => true,
                'tagName'=> ''
            ]);
        }
        else{
            $tag = Tag::updateOrCreate([
                'name' => $tagName,
            ]);
        }
        $member->tags()->attach($tag->id);
        NotificationController::TagNotification($tag,$username,"Member",'Created');
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
    
    public function deleteProjectTag(string $project_id, string $tag_id):JsonResponse{
        $project = Project::find($project_id);
        $tag = Tag::find($tag_id);
        $project->tags()->detach($tag_id);
        NotificationController::TagNotification($tag,$project_id,"Project",'Deleted');
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
    public function deleteWorldTag(string $id, string $tag_id):JsonResponse{
        $world = World::find($id);
        $tag = Tag::find($tag_id);
        error_log($tag);
        NotificationController::TagNotification($tag,$id,"World",'Deleted');
        $world->tags()->detach($tag_id);
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
    public function deleteMemberTag(string $username, string $tag_id):JsonResponse{
        $member = Member::where('name',$username)->first();
        $tag = Tag::find($tag_id);
        NotificationController::TagNotification($tag,$username,"Member",'Deleted');
        $member->tags()->detach($tag_id);
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
   }
}
