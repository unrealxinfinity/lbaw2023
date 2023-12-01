<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Tag;
use App\Models\Project;
use App\Http\Requests\CreateTagRequest;
use App\Events\CreateTag;
class TagController extends Controller
{
    public function createProjectTag(CreateTagRequest $request,string $project_id):JsonResponse{
        $fields = $request->validate(['tagName' => ['required', 'string', 'max:255']]);
        if(Tag::where('name',$fields['tagName'])->exists()){
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
        
        $project = Project::find($project_id);
        $request->authorize($project);
        $project->tags()->attach($tag->id);

        event(new CreateTag($fields['tagName'],$project_id));
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
   
}
