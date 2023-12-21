@extends('layouts.app')

@section('title', 'Login')

@section('content')
<form method="POST" class="form-outline first-letter" action="{{ route('login') }}">
    <fieldset class="form-post">
        <legend>Login</legend>
        {{ csrf_field() }}

        <h3><label for="username">Username</label></h3>
        <input id="username" type="text" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus tabindex="0">
        @if ($errors->has('username'))
            <span class="error">
            {{ $errors->first('username') }}
            </span>
        @endif

        <h3><label for="password" >Password</label></h3>
        <input id="password" type="password" placeholder="Password" name="password" required tabindex="0">
        <h3><a href="/recover">Forgot your password?</a></h3>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <h3><label><input type="checkbox" name="remember" tabindex="0" {{ old('remember') ? 'checked' : '' }}> Remember Me</label></h3>
        <div class="flex">
        <button class="button w-fit mx-3" type="submit" tabindex="0"> Login </button>
        <a class="link self-center" href="{{ route('register') }}" tabindex="0">Register</a>
        </div>
    </fieldset>
</form>
<form method="GET" action="{{ route('github-login') }}">
    <fieldset>
        <legend>Or login with GitHub</legend>
        <input class="button" type="submit" value="Login via GitHub" tabindex="0">
    </fieldset>
</form>
@endsection