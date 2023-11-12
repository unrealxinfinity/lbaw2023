<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function show(string $id): View
    {
        $member = Member::findOrFail($id);

        return view('pages.member', [
            'member' => $member
        ]);
    }
}
