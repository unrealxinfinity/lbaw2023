<?php

namespace App\Http\Controllers;

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

    public function update(Request $request, string $id): void
    {
        $fields = $request->validate([
           'birthday' => ['required'],
           'name' => ['required', 'alpha_num:ascii'],
            'description' => ['required', 'alpha_num:ascii'],
            'email' => ['required', 'email']
        ]);

        $member = Member::findOrFail($id);

        $this->authorize('edit', $member);

        $member->birthday = $fields['birthday'];
        $member->username = $fields['username'];
        $member->description = $fields['description'];
        $member->email = $fields['email'];

        $member->save();
    }

    public function list(string $search = "")
    {
        return Member::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')->get();
    }

    
}
