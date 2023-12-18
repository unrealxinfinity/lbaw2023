@extends('layouts.app')

@section('title', 'Register and Accept Invite')

@section('content')

    <h1 class="my-0 mt-3">Register to join MineMax and <a href="/worlds/{{ $world_id }}">{{ $world_name }}</a></h1>

    <form method="POST" class="form-outline" action="{{ route('register') }}">
        <fieldset class="form-post">
            <legend>Register</legend>
            {{ csrf_field() }}

            <input type="hidden" name="member" value="on">

            <h3 class="my-0 mt-3"><label for="username">Username</label></h3>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
            @if ($errors->has('username'))
            <span class="error">
                {{ $errors->first('username') }}
            </span>
            @endif

            <h3 class="my-0 mt-1"><label for="email">E-Mail Address</label></h3>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{$email}}" required>
            @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
            @endif

            <h3 class="my-0 mt-1"><label for="password">Password</label></h3>
            <input id="password" type="password" name="password" required>
            @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
            @endif

            <h3 class="my-0 mt-1"><label for="password-confirm">Confirm Password</label></h3>
            <input id="password-confirm" type="password" name="password_confirmation" required>

            <input type="hidden" name="invite_token" value="{{ $token }}">

            <button class="button" type="submit"> Register </button>
        </fieldset>
    </form>
@endsection