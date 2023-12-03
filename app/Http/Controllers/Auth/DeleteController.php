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
        $member->picture = null;

        $member->save();
        $persistentUser->save();
        $user->delete();

        return redirect()->route('home')->withSuccess('Account deleted.');
    }

    public function showConfirmation(Request $request, string $username)
    {
        $member = User::where('username', $username)->first()->persistentUser->member;
        $url = str_replace('localhost', '127.0.0.1', $request->session()->previousUrl());
        error_log($url);
        $expected = str_replace('localhost', '127.0.0.1', env('APP_URL') . '/members/' . $username);
        error_log($expected);
        if (Auth::check() && $url == $expected) {
            return view('pages.delete', ['member' => $member]);
        } else {
            return redirect('');
        }        
    }

}
