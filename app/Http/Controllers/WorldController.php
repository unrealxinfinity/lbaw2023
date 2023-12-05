<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\JoinWorldRequest;
use App\Http\Requests\LeaveWorldRequest;
use App\Http\Requests\RemoveMemberFromWorldRequest;
use App\Models\Invitation;
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
use App\Http\Requests\DeleteWorldRequest;
use App\Mail\MailModel;
use Illuminate\Support\Facades\Mail;
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
    public function delete(DeleteWorldRequest $request, string $id): RedirectResponse
    {
        error_log("delete");
        $request->validated();
        $world = World::findOrFail($id);
        $world->delete();
        return redirect()->route('home')->withSuccess('World deleted!');
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

    public function invite(AddMemberToWorldRequest $request, string $world_id): JsonResponse
    {   
        $fields = $request->validated();
        $world = World::findOrFail($world_id);
        

        try
        {
            $member = User::where('username', $fields['username'])->first()->persistentUser->member;
            if($member->worlds->contains('id', $world_id)) return redirect()->back()->withError('User already in the world.');

            $inviteToken = bin2hex(random_bytes(32));

            Invitation::create([
                'token' => $inviteToken,
                'world_id' => $world_id,
                'member_id' => $member->id,
                'type' => $fields['type']
            ]);
        

            $mailData = [
                'view' => 'emails.invite',
                'name' => $member->name,
                'world_name' => $world->name,
                'link' => env('APP_URL') . '/invite?username=' . $fields['username'] . '&adm='. $fields['type'] . '&wid=' . $world_id . '&token=' . $inviteToken
            ];

            Mail::to($member->email)->send(new MailModel($mailData));

            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $fields['username']
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => true,
                'username' => $fields['username']
            ]);
        }
    }

    public function showInvite(): View
    {
        $world_id = request()->query('wid');
        $world_name = World::findOrFail($world_id)->name;
        $username = request()->query('username');
        $token = request()->query('token');
        $type = request()->query('adm');

        return view('pages.invite', [
            'world_id' => $world_id,
            'world_name' => $world_name,
            'username' => $username,
            'token' => $token,
            'type' => $type
        ]);
    }

    public function join(JoinWorldRequest $request) : RedirectResponse
    {
        $fields = $request->validated();

        $world = World::findOrFail($fields['world_id']);
        $member = User::where('username', $fields['username'])->first()->persistentUser->member;
        Invitation::where('token', $fields['token'])->delete();

        if($fields['acceptance'] === "false") return redirect()->route('home')->withSuccess('You rejected the invitation.');

        NotificationController::WorldNotification($world,$member->name . ' added to ');
        $world->members()->attach($member->id, ['is_admin' => $fields['type']]);

        return redirect()->route('worlds.show', ['id' => $fields['world_id']])->withSuccess('You joined the world.');
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
