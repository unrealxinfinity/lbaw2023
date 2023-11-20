<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteMemberRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    public function delete(DeleteMemberRequest $request, string $username): RedirectResponse
    {
        $request->validated();

        $member = User::findOrFail($username)->persistentUser->member;
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
