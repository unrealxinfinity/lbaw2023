<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Project;
use App\Http\Requests\CreateTagRequest;
class TagController extends Controller
{
    
    public function createProjectTag(CreateTagRequest $request,string $project_id):JsonResponse{
        error_log("here");
        $fields = $request->validate();
        $tag = Tag::updateOrCreate([
            'name' => $fields['tagName'],
        ]);
        $project = Project::find($project_id);
        $request->authorize($project);
        error_log("here");
        $project->tags()->attach($tag->id);
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
}
