<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecoverRequest;
use App\Http\Requests\ResetRequest;
use App\Mail\MailModel;
use App\Models\Member;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RecoverController extends Controller
{
    function showRecoverForm()
    {
        if (Auth::check()) {
            return redirect('');
        } else {
            return view('auth.recover');
        }
    }

    function showResetForm(Request $request)
    {
        if (Auth::check()) {
            return redirect('');
        } else {
            return view('auth.reset', ['id' => $request->input('id'), 'token' => $request->input('token')]);
        }
    }

    function send(RecoverRequest $request): RedirectResponse 
    {
        $fields = $request->validated();

        $recoverToken = bin2hex(random_bytes(32));

        $member = Member::where('email', $fields['email'])->first();

        $member->token = $recoverToken;
        $member->save();

        $mailData = [
            'view' => 'emails.recover',
            'name' => $member->name,
            'link' => env('APP_URL') . '/reset?token=' . $recoverToken
        ];

        Mail::to($member->email)->send(new MailModel($mailData));
        return redirect()->back()->withSuccess('Email sent to provided address. Please check your inbox');
    }

    function reset(ResetRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $member = Member::where('token', $fields['token'])->firstOrFail();
        $member->token = null;
        $member->save();

        $user = $member->persistentUser->user;

        $user->password = $fields['password'];
        $user->save();

        return redirect()->route('login')->withSuccess('Password recovered');
    }
}
