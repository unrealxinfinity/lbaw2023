<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Project;
use App\Http\Requests\CreateTagRequest;
class TagController extends Controller
{
    
    public function createProjectTag(CreateTagRequest $request){
        $fields = $request->validated();
        $tag = Tag::updateOrCreate([
            'name' => $fields['tagName'],
        ]);
        $project = Project::find($fields['project_id']);
        $project->tags()->attach($tag->id);
        return response()->json([
            'error' => false,
            'tagName'=> $tag->name
        ]);
    }
}
