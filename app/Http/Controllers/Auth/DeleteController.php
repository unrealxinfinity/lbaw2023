<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteMemberRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function delete(DeleteMemberRequest $request, string $id): RedirectResponse
    {
        $request->validated();

        $member = Member::findOrFail($id);
        $persistentUser = $member->persistentUser;
        $user = $member->persistentUser->user;

        $persistentUser->type_ = 'Deleted';

        $member->name = 'deleted';
        $member->birthday = null;
        $member->description = null;
        $member->email = null;
        $member->picture = 'deleted';

        $member->save();
        $persistentUser->save();
        $user->delete();

        return redirect()->route('home')->withSuccess('Account deleted.');
    }
}
