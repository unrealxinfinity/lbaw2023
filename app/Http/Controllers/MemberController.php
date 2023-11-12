<?php

namespace App\Http\Controllers;

use App\Models\Member;
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

    
}
