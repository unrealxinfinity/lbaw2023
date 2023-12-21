<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Requests\SearchRequest;
use App\Models\Member;
use App\Models\World;
use App\Models\Project;
use App\Models\Task;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
class SearchController extends Controller
{
    public function show(SearchRequest $request): View
    {
        $request->validated();
        $searchedText = strval($request->input('anything'));
        $searchedText = strip_tags($searchedText);
        $typeFilter = $request->input('typeFilter','All');
        $inputTags = $request->input('tags');
        $inputTags= strip_tags($inputTags);
        $order = $request->input('order','Relevance');
        $inputTags = explode(',',$inputTags);
        $arr = explode(' ', $searchedText);
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i] = $arr[$i] . ':*';
        }
        $searchedText = implode(' | ', $arr);
        
        $tasks = (Auth::check())?Task::select('id','title','description','due_at','status','effort','priority')
            ->whereRaw("searchedTasks @@ to_tsquery('english', ?)", [$searchedText])
            ->orderByRaw("ts_rank(searchedTasks, to_tsquery('english', ?)) DESC", [$searchedText])
            ->get():[];
        $projects = Project::select('id', 'name', 'description', 'status', 'picture')
            ->whereRaw("searchedProjects @@ to_tsquery('english', ?)", [$searchedText])
            ->orderByRaw("ts_rank(searchedProjects, to_tsquery('english', ?)) DESC", [$searchedText])
            ->get();
        $members = Member::select('members.id', 'members.user_id', 'members.picture', 'user_info.username','members.name', 'members.email', 'members.birthday', 'members.description')
            ->join('user_info', 'members.user_id', '=', 'user_info.id')
            ->whereRaw('searchMembers @@ to_tsquery(\'english\', ?) OR searchUsername @@ to_tsquery(\'english\', ?)', [$searchedText,$searchedText])
            ->orderByRaw('ts_rank(searchMembers, to_tsquery(\'english\', ?)), ts_rank(searchUsername, to_tsquery(\'english\', ?)) DESC', [$searchedText,$searchedText])
            ->get();
        $worlds = World::select('id', 'picture','name', 'description')
            ->whereRaw("tsvectors @@ to_tsquery('english', ?)", [$searchedText])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$searchedText])
            ->get();
        if($inputTags[0] != ""){
            $membersAux=collect();
            $tasks=collect();
            $projectsAux=collect();
            $worldsAux=collect();
            foreach($members as $member){
                $memberTags = $member->tags;
                $containsAllTags=true;
                $containsATag=false;
                foreach($inputTags as $tagName){
                    if(!$memberTags->contains(function($value, $key) use ($tagName) {
                        return stripos($value->name, $tagName) !== false;
                    })){
                        $containsAllTags=false;
                    }
                    else {
                        $containsATag = true;
                    }
                }
                if($containsATag){
                    $membersAux->push($member);
                }
            }
            $members=$membersAux;

            foreach($projects as $project){
                $projectTags = $project->tags;
                $containsAllTags=true;
                $containsATag=false;
                foreach($inputTags as $tagName){
                    if(!$projectTags->contains(function($value, $key) use ($tagName) {
                        return stripos($value->name, $tagName) !== false;
                    })){
                        $containsAllTags=false;
                    }
                    else {
                        $containsATag = true;
                    }
                }
                if($containsATag){
                    $projectsAux->push($project);
                }
            }
            $projects=$projectsAux;

            foreach($worlds as $world){
                $worldTags = $world->tags;
                $containsAllTags=true;
                $containsATag=false;
                foreach($inputTags as $tagName){
                    if(!$worldTags->contains(function($value, $key) use ($tagName) {
                        return stripos($value->name, $tagName) !== false;
                    })){
                        $containsAllTags=false;
                    }
                    else {
                        $containsATag = true;
                    }
                }
                if($containsATag){
                    $worldsAux->push($world);
                }
            }
            $worlds=$worldsAux;
        }
        if($order == 'A-Z'){
            $members = $members->sortBy('name');
            $projects = $projects->sortBy('name');
            $tasks = $tasks->sortBy('title');
            $worlds = $worlds->sortBy('name');
        }
        else if($order == 'Z-A'){
            $members = $members->sortByDesc('name');
            $projects = $projects->sortByDesc('name');
            $tasks = $tasks->sortByDesc('title');
            $worlds = $worlds->sortByDesc('name');
        }
        
        if($typeFilter == 'All'){
            return view('pages.search', [
                'members' => $members,
                'tasks' => $tasks,
                'projects' => $projects,
                'worlds' => $worlds,
                'search' => $request->input('anything'),
                'type' => $typeFilter,
                'order' => $order
            ]);
        }
        else if($typeFilter == 'Member'){
            $tasks = [];
            $projects = [];
            $worlds = [];   
            return view('pages.search', [
                'members' => $members,
                'tasks' => $tasks,
                'projects' => $projects,
                'worlds' => $worlds,
                'search' => $request->input('anything'),
                'type' => $typeFilter,
                'order' => $order
            ]);
        }
        else if($typeFilter == 'Project'){
            $tasks = [];
            $members = [];
            $worlds = [];
            return view('pages.search', [
                'members' => $members,
                'tasks' => $tasks,
                'projects' => $projects,
                'worlds' => $worlds,
                'search' => $request->input('anything'),
                'type' => $typeFilter,
                'order' => $order
            ]);
        }
        else if($typeFilter == 'Task'){
            $projects = [];
            $members = [];
            $worlds = [];
            return view('pages.search', [
                'members' => $members,
                'tasks' => $tasks,
                'projects' => $projects,
                'worlds' => $worlds,
                'search' => $request->input('anything'),
                'type' => $typeFilter,
                'order' => $order
            ]);
        }
        else if($typeFilter == 'World'){
            $tasks = [];
            $projects = [];
            $members = [];
            return view('pages.search', [
                'members' => $members,
                'tasks' => $tasks,
                'projects' => $projects,
                'worlds' => $worlds,
                'search' => $request->input('anything'),
                'type' => $typeFilter,
                'order' => $order
            ]);
        }
       
        
       
    }
}
