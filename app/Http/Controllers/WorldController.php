<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\LeaveWorldRequest;
use App\Http\Requests\RemoveMemberFromWorldRequest;
use App\Models\World;
use App\Models\User;
use App\Http\Requests\AddMemberToWorldRequest;
use App\Http\Requests\CreateWorldRequest;
use App\Http\Requests\EditWorldRequest;
use App\Models\WorldComment;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Http\Requests\SearchProjectRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class WorldController extends Controller
{
    public function show(string $id): View
    {
        $world = World::findOrFail($id);

        $this->authorize('show', $world);
        
        return view('pages.world', [
            'world' => $world,
            'edit' => false
        ]);
    }

    public function create(CreateWorldRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $world = World::create([
           'name' => $fields['name'],
           'description' => $fields['description'],
           'picture' => 'pic',
           'owner_id' => Auth::user()->persistentUser->member->id
        ]);
        
        $world->members()->attach(Auth::user()->persistentUser->member->id, ['is_admin' => true]);

        return to_route('worlds.show', ['id' => $world->id])->withSuccess('New World created!');
    }

    public function update(EditWorldRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        $world = World::findOrFail($id);

        $world->name = $fields['name'];
        $world->description = $fields['description'];
        
        $world->save();

        return redirect()->route('worlds.show', $id);
    }

    public function addMember(AddMemberToWorldRequest $request,string $world_id, string $username): JsonResponse
    {   
        $fields = $request->validated();

        $world = World::findOrFail($world_id);
        error_log($world);
        $member = User::where('username', $username)->first()->persistentUser->member;
        try {
            $member->worlds()->attach($world_id, ['is_admin' => $fields['type']]);
            NotificationController::WorldNotification($world,$member->name . ' added to ');
            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'world_id' => $world->id,
                'picture' => $member->picture
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'username' => $username,
                'child' => 'world'
            ]);
        }
    }

    public function removeMember(RemoveMemberFromWorldRequest $request, string $world_id, string $username) : JsonResponse
    {   
        $request->validated();
        
        $member = User::where('username', $username)->first()->persistentUser->member;

        
        try {
            $world = World::findOrFail($world_id);
            NotificationController::WorldNotification($world,$member->id . 'removed from ');
            $member->worlds()->detach($world_id);
            return response()->json([
                'error' => false,
                'id' => $world_id,
                'member_id' => $member->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'id' => $world_id,
            ]);
        }
    }

    public function leave(LeaveWorldRequest $request, string $world_id): RedirectResponse
    {
        try {
            $request->validated();

            $world = World::findOrFail($world_id);
            $member = Auth::user()->persistentUser->member;
            NotificationController::WorldNotification($world,$member->id . ' left the ');
            $member->worlds()->detach($world_id);
            return redirect()->route('home')->withSuccess('You left the world.');
        } catch (\Exception $e) {
            return redirect()->route("worlds.show", ['id' => $world_id])->withError('You can\'t leave the world.');
        }
    }

    public function comment(CommentRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        WorldComment::create([
            'content' => $fields['text'],
            'world_id' => $id,
            'member_id' => $fields['member']
        ]);

        return redirect()->route('worlds.show', ['id' => $id, '#comments'])->withSuccess('Comment added.');
    }

    public function searchProjects(SearchProjectRequest $request, string $id): JsonResponse
    {   
        $request->validated();
        $world = World::findOrFail($id);
        $searchProject = $request->query('search');
        $searchProject = strip_tags($searchProject);
        $order= $request->query('order');
        $arr = explode(' ', $searchProject);
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i] = $arr[$i] . ':*';
        }
        $searchProject = implode(' | ', $arr);
        
        $projects = Project::select('id', 'name', 'description', 'status', 'picture')
            ->whereRaw("searchedProjects @@ plainto_tsquery('english', ?) AND world_id = ?", [$searchProject, $id])
            ->orderByRaw("ts_rank(searchedProjects, plainto_tsquery('english', ?)) DESC", [$searchProject])
            ->get();
        if($order == 'A-Z'){
            $projects = $projects->sortByDesc('name')->values();
        }
        else if($order == 'Z-A'){
            $projects = $projects->sortBy('name')->values();
        }
        
        $projectsJson = $projects->toJson();
        return response()->json([
            'projects' => $projectsJson,
        ]);
    }

    public function showEditWorld(string $id): View
    {
        $world = World::findOrFail($id);

        $this->authorize('edit', $world);

        return view('pages.world', [
            'world' => $world,
            'edit' => true
        ]);
    }
}
