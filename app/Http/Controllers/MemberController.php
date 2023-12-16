<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealRequest;
use App\Http\Requests\BlockRequest;
use App\Http\Requests\EditMemberRequest;
use App\Models\Appeal;
use App\Models\Member;
use App\Models\PersistentUser;
use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
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
        $user = User::where('username', $username)->firstOrFail();
        if($user->persistentUser->type_ == "Administrator"){
            abort(404);
        }
        $member = $user->persistentUser->member;

        return view('pages.member', [
            'member' => $member,
            'appeal' => false,
            'tags' => $member->tags
        ]);
    }

    public function showAppeal(): View
    {
        $this->authorize('appeal', Member::class);

        $member = Auth::user()->persistentUser->member;

        return view('pages.member', [
            'member' => $member,
            'appeal' => true
        ]);
    }

    public function denyAppeal(int $id): RedirectResponse
    {
        $this->authorize('create', Member::class);

        $appeal = Appeal::findOrFail($id);
        $appeal->delete();

        return redirect()->back()->withResponse('Appeal denied.');
    }

    public function appeal(AppealRequest $request, int $id): RedirectResponse
    {
        $fields = $request->validated();
        $member = Member::findOrFail($id);

        Appeal::create([
            'text' => $fields['text'],
            'member_id' => $member->id
        ]);

        return redirect()->route('members.show', ['username' => $member->persistentUser->user->username])->withSuccess('Appeal sent!');
    }

    public function showCreateWorld(): View
    {
        $this->authorize('showCreateWorld', Member::class);

        return view('pages.world-create');
    }

    public function showEditProfile(string $username): View
    {
        $user = User::where('username', $username)->firstOrFail();
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

    public function showMemberFavorites(): View
    {
        $this->authorize('showMemberFavorites', Member::class);
        $id = Auth::user()->persistentUser->member->id;
        $worlds = Member::findOrFail($id)->favoriteWorld;
        $projects = Member::findOrFail($id)->favoriteProject;
        return view('pages.myfavorites', ['worlds' => $worlds, 'projects' => $projects]);
    }

    public function showInvites(): View
    {
        $this->authorize('showInvites', Member::class);
        $id = Auth::user()->persistentUser->member->id;
        $invites = Member::findOrFail($id)->invitations;
        return view('pages.invites', ['invites' => $invites]);
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

        $members = Member::where(function ($query) use($search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        })->where(function ($query) {
                $query->whereRaw("(select type_ from users where users.id = members.user_id) != 'Deleted'");
            })->cursorPaginate(2)->withQueryString()->withPath(route('list-members'));

        return view('pages.admin-members', ['members' => $members]);
    }
    public function getAllBelongings():JsonResponse
    {
        $member = Member::where('user_id', Auth::user()->id)->firstOrFail();
        $worlds = $member->worlds->pluck('id');
        $projects = $member->projects->pluck('id');

        return response()->json([
            'worlds_ids' => $worlds,
            'projects_ids' => $projects
        ]);

    }

    public function block(BlockRequest $request, string $username): RedirectResponse
    {
        $request->validated();

        $user = User::where('username', $username)->firstOrFail();

        $user->persistentUser->type_ = 'Blocked';
        $user->persistentUser->save();

        return redirect()->back()->withSuccess('User blocked')->withFragment($username);
    }

    public function unblock(BlockRequest $request, string $username): RedirectResponse
    {
        $request->validated();

        $user = User::where('username', $username)->firstOrFail();

        if ($user->persistentUser->type_ == 'Blocked') {
            $user->persistentUser->type_ = 'Member';
            $user->persistentUser->save();

            if (isset($user->persistentUser->member->appeal)) {
                $user->persistentUser->member->appeal->delete();
            }
        }    

        return redirect()->back()->withSuccess('User unblocked')->withFragment($username);
    }
}
