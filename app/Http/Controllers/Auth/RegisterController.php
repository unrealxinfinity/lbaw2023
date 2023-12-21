<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Invitation;
use App\Models\PersistentUser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\UserType;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm()
    {
        if(Auth::check()) {
            return redirect()->route('home');
        }
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
            'name' => 'nullable|string|max:250',
            'invite_token' => 'nullable'
        ]);

        $login = $request->login ?? true;
        $member = $request->member === 'on';

        $name = $request->name ?? 'New Member';
        $persistentUser = PersistentUser::create([
            'type_' => $member ? UserType::Member->value : UserType::Administrator->value
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_id' => $persistentUser->id,
            'has_password' => true
        ]);

        if ($member) {
            Member::create([
                'name' => $name,
                'email' => $request->email,
                'user_id' => $persistentUser->id
            ]);

            if($request->invite_token) {
                $invite = Invitation::where('token', $request->invite_token)->first();
                $member = Member::where('user_id', $persistentUser->id)->first();
                
                $member->worlds()->attach($invite->world_id, ['is_admin' => $invite->is_admin]);

                if ($invite) {
                    $invite->delete();
                }
            }
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
