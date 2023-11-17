<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMemberRequest;
use App\Models\Member;
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

    public function showMemberWorlds(): View
    {
        $id = Auth::user()->persistentUser->member->id;
        $worlds = Member::findOrFail($id)->worlds;
        return view('pages.myworlds', ['worlds' => $worlds]);
    }

    public function update(EditMemberRequest $request, string $id): void
    {
        $fields = $request->validated();

        $member = Member::findOrFail($id);

        //$this->authorize('edit', $member);

        $member->birthday = $fields['birthday'];
        $member->name = $fields['name'];
        $member->description = $fields['description'];
        $member->email = $fields['email'];

        $member->save();
    }

    public function list(string $search = ""): View
    {
        $this->authorize('list', Member::class);        

        $members = Member::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')->get();

        return view('pages.admin-members', ['members' => $members]);
    }

    
}
