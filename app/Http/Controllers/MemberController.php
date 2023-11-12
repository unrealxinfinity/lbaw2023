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
        $id = Auth::id();
        $worlds = Member::findOrFail($id)->worlds;
        return view('pages.myworlds', ['worlds' => $worlds]);
    }

    public function update(Request $request): void
    {
        $fields = $request->validate([
           'birthday' => ['required, date_format:YY-MM-DD'],
           'name' => ['required', 'alpha_num:ascii'],
            'description' => ['required', 'alpha_num:ascii'],
            'email' => ['required', 'email'],
            'id' => ['required', 'integer', 'numeric']
        ]);

        $member = Member::findOrFail($fields['id']);

        $this->authorize('edit', $member);

        $member->birthday = $fields['birthday'];
        $member->username = $fields['username'];
        $member->description = $fields['description'];
        $member->email = $fields['email'];

        $member->save();
    }

    
}
