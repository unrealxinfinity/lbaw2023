@extends('layouts.app')

@section('content')
<form method="POST" class="form-post first-letter" action="{{ route('login') }}">
    {{ csrf_field() }}

    <label for="username">Username</label>
    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
        <span class="error">
          {{ $errors->first('username') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required>
    <a href="/recover">Forgot your password?</a>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>
    <div class="flex">
    <button class="button w-1/4" type="submit"> Login </button>
    <a class="button text-white bg-grey" href="{{ route('register') }}">Register</a>
    </div>
    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif
</form>
<form method="GET" action="{{ route('github-login') }}">
    <input class="button" type="submit" value="Login via GitHub">
</form>
@endsection