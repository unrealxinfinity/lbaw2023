<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Project;
use App\Http\Requests\CreateTagRequest;
class TagController extends Controller
{
    public function showProjectTags($id){
        
        $tags = Project::findOrFail($id)->tags;
    
        return view('partials.tag', ['tags'=>$tags]);
    }
    public function createProjectTag(CreateTagRequest $request, $id){
        error_log($request);
        $fields = $request->validated();
        $tag = Tag::create([
            'name' => request('tagName')
        ]);
    }
}
