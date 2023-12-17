<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\JoinWorldRequest;
use App\Http\Requests\LeaveWorldRequest;
use App\Http\Requests\RemoveMemberFromWorldRequest;
use App\Models\Invitation;
use App\Models\World;
use App\Models\User;
use App\Models\Member;
use App\Http\Requests\AddMemberToWorldRequest;
use App\Http\Requests\CreateWorldRequest;
use App\Http\Requests\EditWorldRequest;
use Illuminate\Http\Request;
use App\Models\WorldComment;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Http\Requests\SearchProjectRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
use App\Http\Requests\DeleteWorldRequest;
use App\Http\Requests\TransferOwnershipRequest;
use App\Mail\MailModel;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AssignWorldAdminRequest;
use App\Models\Tag;

class WorldController extends Controller
{
    public function show(string $id): View
    {
        $world = World::findOrFail($id);

        $this->authorize('show', $world);
        
        return view('pages.world', [
            'world' => $world,
            'subform' => false,
            'members' => $world->members()->get()->reject(function ($member) {
                return $member->persistentUser->type_ != "Member";
            }),
            'tags' => $world->tags
        ]);
    }

    public function showAll(Request $request): View
    {
        $search = $request['search'] ?? "";

        $worlds = World::where(function ($query) use($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->cursorPaginate(10)->withQueryString()->withPath(route('show-all-worlds'));

        return view('pages.worlds', [
            'worlds' => $worlds
        ]);
    }

    public function create(CreateWorldRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $world = World::create([
           'name' => $fields['name'],
           'description' => $fields['description'],
           'picture' => null,
           'owner_id' => Auth::user()->persistentUser->member->id
        ]);
        
        $world->members()->attach(Auth::user()->persistentUser->member->id, ['is_admin' => true]);
        NotificationController::WorldNotification($world,'You created the ');
        return to_route('worlds.show', ['id' => $world->id])->withSuccess('New World created!');
    }
    public function delete(DeleteWorldRequest $request, string $id): RedirectResponse
    {
        $request->validated();
        $world = World::findOrFail($id);
        $world->delete();
        return redirect()->route('home')->withSuccess('World deleted!');
    }

    public function deleteFromList(DeleteWorldRequest $request, string $id): JsonResponse
    {
        $request->validated();
        $world = World::findOrFail($id);
        $world->delete();
        NotificationController::WorldNotification($world,'You deleted the ');
        return response()->json([
            'error' => false,
            'id' => $id,
        ]);
    }

    public function update(EditWorldRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        $world = World::findOrFail($id);

        $world->name = $fields['name'];
        $world->description = $fields['description'];
        
        $world->save();
        $member = Auth::user()->persistentUser->member;
        NotificationController::WorldNotification($world,$member->name .' updated the ');
        return redirect()->route('worlds.show', $id);
    }

    public function invite(AddMemberToWorldRequest $request, string $world_id): JsonResponse
    {   
        $fields = $request->validated();
        $world = World::findOrFail($world_id);

        try
        {
            $inviteToken = bin2hex(random_bytes(32));

            if($fields['username'] != null){
                $member = User::where('username', $fields['username'])->first()->persistentUser->member;
            } else if ($fields['email'] != null){
                $member = Member::where('email', $fields['email'])->first();
                if($member == null){

                    Invitation::create([
                        'token' => $inviteToken,
                        'world_id' => $world_id,
                        'email' => $fields['email'],
                        'is_admin' => $fields['type']
                    ]);

                    $mailData = [
                        'view' => 'emails.new-member-invite',
                        'world_name' => $world->name,
                        'link' => env('APP_URL') . '/invite?token=' . $inviteToken
                    ];

                    Mail::to($fields['email'])->send(new MailModel($mailData));
                    
                    return response()->json([
                        'error' => false,
                        'email' => $fields['email']
                    ]);
                }
                else {
                    throw new \Exception('Member already has a MineMax account.');
                }
            } else {
                throw new \Exception('No username or email provided.');
            }
           
            if($member->worlds->contains('id', $world_id)) throw new \Exception('Member already in world.');
            

            Invitation::create([
                'token' => $inviteToken,
                'world_id' => $world_id,
                'member_id' => $member->id,
                'is_admin' => $fields['type']
            ]);
        

            $mailData = [
                'view' => 'emails.invite',
                'name' => $member->name,
                'world_name' => $world->name,
                'link' => env('APP_URL') . '/invite?token=' . $inviteToken
            ];

            Mail::to($member->email)->send(new MailModel($mailData));

            return response()->json([
                'error' => false,
                'username' => $fields['username']
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => true,
                //'username' => $fields['username'],
                'username' => 'test',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function assignNewWorldAdmin(AssignWorldAdminRequest $request, string $id): JsonResponse
    {   

        $fields = $request->validated();
        $world = World::findOrFail($id);
        $member = User::where('username', $fields['username'])->first()->persistentUser->member;
        
        $member->worlds()->updateExistingPivot($id, ['is_admin' => true]);
        NotificationController::WorldNotification($world,$member->name . ' promoted in ');
        return response()->json([
            'error' => false,
            'id' => $member->id,
            'username' => $fields['username'],
            'world_id' => $world->id,
            'picture' => $member->picture
        ]);
        
    }
    public function demoteWorldAdmin(AssignWorldAdminRequest $request, string $id): JsonResponse
    {   
        $fields = $request->validated();
        $world = World::findOrFail($id);
        $member = User::where('username', $fields['username'])->first()->persistentUser->member;
       
        $member->worlds()->updateExistingPivot($id, ['is_admin' => false]);
        NotificationController::WorldNotification($world,$member->name . ' demoted in ');
        return response()->json([
            'error' => false,
            'id' => $member->id,
            'username' => $fields['username'],
            'world_id' => $world->id,
            'picture' => $member->picture
        ]);
    }
    public function showInvite()
    {

        $token = request()->query('token');

        $invitation = Invitation::where('token', $token)->firstOrFail();

        if($invitation->username != null){
            $username = $invitation->member->user->username;
            $world_id = $invitation->world_id;
            $world_name = World::findOrFail($world_id)->name;

            return view('pages.invite', [
                'world_id' => $world_id,
                'world_name' => $world_name,
                'username' => $username,
                'token' => $token
            ]);
        } else if ($invitation->email != null){
            if(Auth::check()) {
                return redirect()->route('home');
            }
            $email = $invitation->email;
            $world_id = $invitation->world_id;
            $world_name = World::findOrFail($world_id)->name;

            return view('auth.register-invite', [
                'world_id' => $world_id,
                'world_name' => $world_name,
                'email' => $email,
                'token' => $token
            ]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function join(JoinWorldRequest $request) : RedirectResponse
    {
        $fields = $request->validated();

        $invitation = Invitation::where('token', $fields['token'])->first();

        $invitation->delete();

        if($fields['acceptance'] == 0) {
            return redirect()->route('show-invites')->withSuccess('You rejected the invitation.');
        }

        $world = World::findOrFail($invitation->world_id);
        $member = $invitation->member;

        NotificationController::WorldNotification($world,$member->name . ' added to ');

        $world->members()->attach($member->id, ['is_admin' => $invitation->is_admin]);

        return redirect()->route('worlds.show', ['id' => $invitation->world_id])->withSuccess('You joined the world.');
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
            NotificationController::WorldNotification($world, 'You left the ');
            $member->worlds()->detach($world_id);
            return redirect()->route('home')->withSuccess('You left the world.');
        } catch (\Exception $e) {
            return redirect()->route("worlds.show", ['id' => $world_id])->withError('You can\'t leave the world.');
        }
    }

    public function leaveFromList(LeaveWorldRequest $request, string $world_id): JsonResponse
    {
        try {
            $request->validated();
            $world = World::findOrFail($world_id);
            $member = Auth::user()->persistentUser->member;
            NotificationController::WorldNotification($world,'You left the ');
            $member->worlds()->detach($world_id);
            return response()->json([
                'error' => false,
                'id' => $world_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'id' => $world_id
            ]);
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
        $inputTags = $request->query('tags');
        $inputTags= strip_tags($inputTags);
        $inputTags = explode(',',$inputTags);
        $arr = explode(' ', $searchProject);
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i] = $arr[$i] . ':*';
        }
        $searchProject = implode(' | ', $arr);
        
        $projects = Project::select('id', 'name', 'description', 'status', 'picture')
            ->whereRaw("searchedProjects @@ plainto_tsquery('english', ?) AND world_id = ?", [$searchProject, $id])
            ->orderByRaw("ts_rank(searchedProjects, plainto_tsquery('english', ?)) DESC", [$searchProject])
            ->get()
            ->map(function ($project) {
                $project->picture = $project->getImage();
                return $project;
            });
        if($inputTags[0] != ""){
            $projectsAux=collect();
            foreach($projects as $project){
                $projectTags = $project->tags;
                $containsAllTags=true;
                foreach($inputTags as $tagName){
                    if(!$projectTags->contains(function($value, $key) use ($tagName) {
                        return stripos($value->name, $tagName) !== false;
                    })){
                        $containsAllTags=false;
                    }
                }
                if($containsAllTags){
                    $projectsAux->push($project);
                }
            }
            $projects=$projectsAux;
            error_log($projects);
        }
        
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
            'subform' => true,
            'formTitle' => 'Edit World',
            'formName' => 'form.world-edit',
            'members' => $world->members()->get()->reject(function ($member) {
                return $member->persistentUser->type_ != "Member";
            })
        ]);
    }

    public function favorite(string $id): JsonResponse
    {
        $world = World::findOrFail($id);
        $this->authorize('favorite', $world);
        $member = Auth::user()->persistentUser->member;

        try {
            if ($member->favoriteWorld->contains('id', $id)) {
                $member->favoriteWorld()->detach($id);
                $favorite = false;
            } else {
                $member->favoriteWorld()->attach($id);
                $favorite = true;
            }

            $member->save();
            
            return response()->json([
                'error' => false,
                'favorite' => $favorite,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true
            ]);
        }
    }

    public function showTransfer(string $id): View
    {
        $world = World::findOrFail($id);

        $this->authorize('edit', $world);

        return view('pages.world', [
            'world' => $world,
            'subform' => true,
            'formTitle' => 'Transfer Ownership',
            'formName' => 'form.transferownership',
            'members' => $world->members()->get()->reject(function ($member) {
                return $member->persistentUser->type_ != "Member";
            })
        ]);
    }

    public function transfer(TransferOwnershipRequest $request, string $id)
    {
        $fields = $request->validated();

        $member = Member::findOrFail($fields['owner']);
        $world = World::findOrFail($id);

        if (!$member->worlds->contains('id', $id) || $member->persistentUser->type_ != 'Member') {
            return redirect()->back()->withError("This member isn't a valid choice!");
        }

        $member->worlds()->updateExistingPivot($id, [
            'is_admin' => true
        ]);

        $world->owner_id = $member->id;
        $world->save();
        
        return redirect()->route('worlds.show', ['id' => $id])->withSuccess('Owner transfered');
    }
}
