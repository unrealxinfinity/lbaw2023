<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorldCommentRequest;
use App\Models\World;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\AddMemberToWorldRequest;
use App\Http\Requests\CreateWorldRequest;
use App\Http\Requests\SearchProjectRequest;
use App\Models\WorldComment;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WorldController extends Controller
{
    public function show(string $id): View
    {
        $world = World::findOrFail($id);

        $this->authorize('show', $world);
        
        return view('pages.world', [
            'world' => $world
        ]);
    }

    public function showProjectCreate(string $id): View
    {
        $world = World::findOrFail($id);
        return view('pages.project-create', ['world' => $world]);
    }

    public function create(CreateWorldRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $world = World::create([
           'name' => $fields['name'],
           'description' => $fields['name'],
           'picture' => 'pic',
           'owner_id' => Auth::user()->persistentUser->member->id
        ]);

        $world->members()->attach(Auth::user()->persistentUser->member->id, ['is_admin' => true]);

        return to_route('worlds.show', ['id' => $world->id])->withSuccess('New World created!');
    }

    public function addMember(AddMemberToWorldRequest $request,string $world_id, string $username): JsonResponse
    {   
        $fields = $request->validated();

        $world = World::findOrFail($world_id);
        $member = User::where('username', $username)->first()->persistentUser->member;

        $member->worlds()->attach($world_id, ['is_admin' => $fields['type']]);

        return response()->json([
            'id' => $member->id,
            'username' => $username,
            'email' => $member->email,
            'is_admin' => $fields['type'],
            'description' => $member->description
        ]);
    }
    public function searchProjects(SearchProjectRequest $request, string $id): JsonResponse
    {   


        $world = World::findOrFail($id);
        
        $searchProject = $request->query('search');
        $searchProject = str_replace(['&', '&lt;', '&gt;', '<', '>'], ['','','', '', ''], $searchProject);
        
        $projects = Project::select('id', 'name', 'description', 'status', 'picture')
            ->whereRaw("searchedProjects @@ plainto_tsquery('english', ?) AND id = ?", [$searchProject, $id])
            ->orderByRaw("ts_rank(searchedProjects, plainto_tsquery('english', ?)) DESC", [$searchProject])
            ->get();
        $projectsJson = $projects->toJson();
        return response()->json([
            'projects' => $projectsJson,
        ]);
    }
    public function comment(WorldCommentRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        WorldComment::create([
            'content' => $fields['text'],
            'world_id' => $id,
            'member_id' => $fields['member']
        ]);

        return redirect()->route('worlds.show', ['id' => $id, '#comments'])->withSuccess('Comment added.');
    }
}
