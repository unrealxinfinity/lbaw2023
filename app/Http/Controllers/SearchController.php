<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SearchRequest;
use App\Models\Task;
use App\Models\Project;
use App\Models\Member;
use App\Models\World;
use App\Models\UserInfo;

class SearchController extends Controller
{
    public function show(Request $request): View
    {
        
        $searchedText = strval($request->input('anything'));
        $searchedText = str_replace(['&', '&lt;', '&gt;', '<', '>'], ['','','', '', ''], $searchedText);    
        $member = Member::where('user_id', auth()->user()->id)->first(); 
        $id = $member->user_id;
        $tasks = $member->tasks()->select('id','title','description','due_at','status','effort','priority')->whereRaw("searchedTasks @@ plainto_tsquery('english', ?) AND project_id = ?", [$searchedText, $id])
            ->orderByRaw("ts_rank(searchedTasks, plainto_tsquery('english', ?)) DESC", [$searchedText])
            ->get();
        $projects = $member->projects()->select('id', 'name', 'description', 'status', 'picture')
        ->whereRaw("searchedProjects @@ plainto_tsquery('english', ?)", [$searchedText])
        ->orderByRaw("ts_rank(searchedProjects, plainto_tsquery('english', ?)) DESC", [$searchedText])
        ->get();
        error_log($searchedText);
        $members = Member::select('members.id', 'members.picture', 'user_info.username', 'members.email', 'members.birthday', 'members.description')
        ->join('user_info', 'members.id', '=', 'user_info.id')
        ->whereRaw('searchMembers @@ plainto_tsquery(\'english\', ?)', [$searchedText])
        ->orderByRaw('ts_rank(searchMembers, plainto_tsquery(\'english\', ?)) DESC', [$searchedText])
        ->get();
        
        $worlds = $member->worlds()->select('picture','name', 'description')
        ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$searchedText])
        ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$searchedText])
        ->get();
        error_log($tasks);
        error_log($projects);
        error_log($members);
        error_log($worlds);
        
        return view('pages.search', [
            'members' => $members,
            'tasks' => $tasks,
            'projects' => $projects,
            'worlds' => $worlds
        ]);
    }
}
