<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Tag;
use App\Models\Project;
use App\Http\Requests\CreateProjectTagRequest;
use App\Http\Requests\CreateWorldTagRequest;
use App\Events\CreateTag;
use App\Models\World;
use App\Http\Controllers\NotificationController;
class TagController extends Controller
{
    public function createProjectTag(CreateProjectTagRequest $request,string $project_id):JsonResponse{

        $fields = $request->validate(['tagName' => ['required', 'string', 'max:30']]);

        $project = Project::find($project_id);
        if($project->tags()->where('name',$fields['tagName'])->exists()){
            return response()->json([
                'error' => true,
                'tagName'=> ''
            ]);
        }
        else{
            $tag = Tag::updateOrCreate([
                'name' => $fields['tagName'],
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
        $world = World::find($id);
        if($world->tags()->where('name',$fields['tagName'])->exists()){
            return response()->json([
                'error' => true,
                'tagName'=> ''
            ]);
        }
        else{
            $tag = Tag::updateOrCreate([
                'name' => $fields['tagName'],
            ]);
        }
        
        $world->tags()->attach($tag->id);
        
        NotificationController::TagNotification($tag,$id,"World",'Created');
        
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
   
}
