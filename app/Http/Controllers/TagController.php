<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Project;
class TagController extends Controller
{
    public function showProjectTags($id){
        
        $tags = Project::findOrFail('id',$id)->tags;
        foreach($projecttags as $projecttag){
            $tags->push($projecttag->tag);
        }
        error_log(count($tags));
        error_log($tags);
        return view('partials.project-tag', ['tags'=>$tags]);
 }
}
