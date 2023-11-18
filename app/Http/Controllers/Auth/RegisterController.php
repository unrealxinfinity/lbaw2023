<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PersistentUser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:250',
            'email' => 'required|email|max:250',
            'password' => 'required|min:8|confirmed',
            'login' => 'nullable|boolean',
            'member' => 'nullable',
            'name' => 'nullable|string|max:250'
        ]);

        error_log("hello");

        $login = $request->login ?? true;
        $member = $request->member === 'on' ?? true;
        $name = $request->name ?? 'New Member';
        $persistentUser = PersistentUser::create([
            'type_' => $member ? 'Member' : 'Administrator'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_id' => $persistentUser->id
        ]);

        if ($member) {
            Member::create([
                'name' => $name,
                'email' => $request->email,
                'user_id' => $persistentUser->id,
                'picture' => 'example.com'
            ]);
        }

        if ($login) {
            $credentials = $request->only('username', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return redirect()->route('home')
                ->withSuccess('You have successfully registered & logged in!');
        }
        else {
            return redirect()->back()->withSuccess('You have created a new account!');
        }
    }
}
