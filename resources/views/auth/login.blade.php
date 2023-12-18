@extends('layouts.app')

@section('title', 'Login')

@section('content')
<form method="POST" class="form-post first-letter" action="{{ route('login') }}">
    <fieldset>
        <legend>Login</legend>
        {{ csrf_field() }}

        <h3><label for="username">Username</label></h3>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
            <span class="error">
            {{ $errors->first('username') }}
            </span>
        @endif

        <h3><label for="password" >Password</label></h3>
        <input id="password" type="password" name="password" required>
        <h3><a href="/recover">Forgot your password?</a></h3>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <h3><label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</label></h3>
        <div class="flex">
        <button class="button w-fit mx-3" type="submit"> Login </button>
        <a class="link self-center" href="{{ route('register') }}">Register</a>
        </div>
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </fieldset>
</form>
<form method="GET" action="{{ route('github-login') }}">
    <fieldset>
        <legend>Or login with GitHub</legend>
        <input class="button" type="submit" value="Login via GitHub">
    </fieldset>
</form>
@endsection