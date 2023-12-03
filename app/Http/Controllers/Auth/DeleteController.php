<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteMemberRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function delete(DeleteMemberRequest $request, string $username): RedirectResponse
    {
        $request->validated();

        $member = User::where('username', $username)->first()->persistentUser->member;
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

    public function showConfirmation(Request $request, string $username)
    {
        $member = User::where('username', $username)->first()->persistentUser->member;

        if (Auth::check()) {
            return view('pages.delete', ['member' => $member]);
        } else {
            return redirect('');
        }        
    }

}
