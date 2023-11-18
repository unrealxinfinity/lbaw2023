<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMemberRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function show(string $id): View
    {
        $member = Member::findOrFail($id);

        return view('pages.member', [
            'member' => $member
        ]);
    }

    public function showEditProfile(string $id): View
    {
        $member = Member::findOrFail($id);

        return view('pages.member-edit', [
            'member' => $member
        ]);
    }

    public function showMemberWorlds(): View
    {
        $id = Auth::user()->persistentUser->member->id;
        $worlds = Member::findOrFail($id)->worlds;
        return view('pages.myworlds', ['worlds' => $worlds]);
    }

    public function update(EditMemberRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        $member = Member::findOrFail($id);

        //$this->authorize('edit', $member);

        $member->birthday = $fields['birthday'];
        $member->name = $fields['name'];
        $member->description = $fields['description'];
        $member->email = $fields['email'];

        $member->save();
        return back()->with('success','Member updated successfully!');
    }

    public function list(Request $request): View
    {
        $this->authorize('list', Member::class);   
        
        $search = $request['search'] ?? "";

        $members = Member::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')->get();

        return view('pages.admin-members', ['members' => $members]);
    }

    
}
