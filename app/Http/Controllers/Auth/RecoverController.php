<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecoverRequest;
use App\Mail\MailModel;
use App\Models\Member;
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

    function showResetForm()
    {
        if (Auth::check()) {
            return redirect('');
        } else {
            return view('auth.reset');
        }
    }

    function send(RecoverRequest $request) 
    {
        $fields = $request->validated();

        $recoverToken = bin2hex(random_bytes(32));

        $member = Member::where('email', $fields['email']);

        $member->recoverToken = $recoverToken;

        $mailData = [
            'name' => $member->name,
            'link' => env('APP_URL') . '/reset-password?id=' . $member->id . '&token=' . $recoverToken
        ];

        Mail::to($fields['email'])->send(new MailModel($mailData));
        return redirect()->back()->withSuccess('Email sent to provided address. Please check your inbox');
    }
}
