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

    public function getMemberWorlds($memberId) {
        $member_world = DB::table('member_world')
            ->where('member_id', $memberId)
            ->get();
        $worlds = [];
        foreach ($member_world as $member_world_row) {
            $world = DB::table('worlds')
                ->where('id', $member_world_row->world_id)
                ->get();
            array_push($worlds, $world);
        }

        return $worlds;
    }

    public function showMemberWorlds(): View
    {
        $id = Auth::id();
        $worlds = $this->getMemberWorlds($id);
        return view('pages.myworlds', ['worlds' => $worlds]);
    }

    
}
