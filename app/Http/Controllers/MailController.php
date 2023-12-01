<?php

namespace App\Http\Controllers;

use App\Mail\MailModel;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
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
