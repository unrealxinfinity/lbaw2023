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
use App\Models\PersistentUser;

class SearchController extends Controller
{
    public function show(SearchRequest $request): View
    {
        $request->validated();
        $searchedText = strval($request->input('anything'));
        $searchedText = strip_tags($searchedText);    
        $member = Member::where('user_id', auth()->user()->id)->first(); 
        $id = $member->user_id;
        $tasks = $member->tasks()->select('id','title','description','due_at','status','effort','priority')
            ->whereRaw("searchedTasks @@ plainto_tsquery('english', ?) AND project_id = ?", [$searchedText, $id])
            ->orderByRaw("ts_rank(searchedTasks, plainto_tsquery('english', ?)) DESC", [$searchedText])
            ->get();
        $projects = $member->projects()->select('id', 'name', 'description', 'status', 'picture')
            ->whereRaw("searchedProjects @@ plainto_tsquery('english', ?)", [$searchedText])
            ->orderByRaw("ts_rank(searchedProjects, plainto_tsquery('english', ?)) DESC", [$searchedText])
            ->get();
        $members = Member::select('members.id', 'members.picture', 'user_info.username','members.name', 'members.email', 'members.birthday', 'members.description')
        ->join('user_info', 'members.id', '=', 'user_info.id')
        ->where(function ($memberQuery) use ($searchedText){
            $admins = PersistentUser::select('id')->where('type_', '=','Administrator')->get();
            $memberQuery->whereNotIn('members.id',$admins)->whereRaw('searchMembers @@ plainto_tsquery(\'english\', ?) OR searchUsername @@ plainto_tsquery(\'english\', ?)', [$searchedText,$searchedText]);
        })
        ->orderByRaw('ts_rank(searchMembers, plainto_tsquery(\'english\', ?)), ts_rank(searchUsername, plainto_tsquery(\'english\', ?)) DESC', [$searchedText,$searchedText])->get();
        $worlds = $member->worlds()->select('picture','name', 'description')
            ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$searchedText])
            ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$searchedText])
            ->get();
        
        
        return view('pages.search', [
            'members' => $members,
            'tasks' => $tasks,
            'projects' => $projects,
            'worlds' => $worlds
        ]);
    }
}
