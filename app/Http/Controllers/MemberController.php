<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMemberRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    public function show(string $username): View
    {
        $user = Auth::user()->persistentUser->user->where('username', $username)->firstOrFail();
        if($user->persistentUser->type_ == "Administrator"){
            abort(404);
        }
        $member = $user->persistentUser->member;

        return view('pages.member', [
            'member' => $member
        ]);
    }

    public function showCreateWorld(): View
    {
        $this->authorize('showCreateWorld', Member::class);

        return view('pages.world-create');
    }

    public function showEditProfile(string $username): View
    {
        $user = Auth::user()->persistentUser->user->where('username', $username)->firstOrFail();
        if($user->persistentUser->type_ == "Administrator"){
            abort(404);
        }
        $member = $user->persistentUser->member;

        return view('pages.member-edit', [
            'member' => $member
        ]);
    }

    public function showMemberWorlds(): View
    {
        $this->authorize('showMemberWorlds', Member::class);
        $id = Auth::user()->persistentUser->member->id;
        $worlds = Member::findOrFail($id)->worlds;
        return view('pages.myworlds', ['worlds' => $worlds]);
    }

    public function showMemberProjects(): View
    {   
        $this->authorize('showMemberProjects', Member::class);
        $id = Auth::user()->persistentUser->member->id;
        $projects = Member::findOrFail($id)->projects;
        return view('pages.myprojects', ['projects' => $projects]);
    }

    public function showMemberTasks(): View
    {
        $this->authorize('showMemberTasks', Member::class);
        $id = Auth::user()->persistentUser->member->id;
        $tasks = Member::findOrFail($id)->tasks;
        return view('pages.mytasks', ['tasks' => $tasks]);
    }

    public function update(EditMemberRequest $request, string $username): RedirectResponse
    {
        $fields = $request->validated();

        $member = User::where('username', $username)->firstOrFail()->persistentUser->member;

        if($member->persistentUser->user->has_password && !Hash::check($fields['old_password'], $member->persistentUser->user->password) && Auth::user()->persistentUser->type_ != "Administrator"){
            return back()->with('error','Password confirmation is incorrect!');
        }

        $oldUsername = $member->persistentUser->user->username;
        $member->persistentUser->user->username = $fields['username'];
        if(isset($fields['password'])) {
            $member->persistentUser->user->password = Hash::make($fields['password']);
            $member->persistentUser->user->has_password = true;
        }
        $member->birthday = $fields['birthday'];
        $member->name = $fields['name'];
        $member->description = $fields['description'];
        $member->email = $fields['email'];

        $member->persistentUser->user->save();
        $member->save();

        if (url()->previous() == route('edit-member', $oldUsername)) {
            return redirect()->route('edit-member', $fields['username'])->with('success','Member updated successfully!');
        }

        return back()->with('success','Member updated successfully!');
    }

    public function list(Request $request): View
    {
        $this->authorize('list', Member::class);   
        
        $search = $request['search'] ?? "";

        $members = Member::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')->cursorPaginate(2)->withPath(route('list-members'));

        return view('pages.admin-members', ['members' => $members]);
    }
    public function getAllBelongings():JsonResponse
    {
        
        $member = Member::where('user_id', Auth::user()->persistentUser->member->id)->firstOrFail();
        $worlds = $member->worlds->pluck('id');
        $projects = $member->projects->pluck('id');

        return response()->json([
            'worlds_ids' => $worlds,
            'projects_ids' => $projects
        ]);

    }
}
