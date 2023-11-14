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
            'password' => 'required|min:8|confirmed'
        ]);

        $persistentUser = PersistentUser::create([
            'type_' => 'Member'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_id' => $persistentUser->id
        ]);

        Member::create([
            'name' => 'New Member',
            'email' => $request->email,
            'user_id' => $persistentUser->id,
            'picture' => 'example.com'
        ]);

        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('cards')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
