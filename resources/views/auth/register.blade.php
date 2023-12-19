@extends('layouts.app')

@section('title', 'Register')

@section('content')
  <form method="POST" class="form-outline" action="{{ route('register') }}"> 
    <fieldset class ="form-post">
        <legend>Register</legend>
        {{ csrf_field() }}

        <input type="hidden" name="member" value="on">

    <h3 class="my-0 mt-3"><label for="username">Username <b class="text-red">*</b></label></h3>
    <input id="username" type="text" name="username" placeholder="New Username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <h3 class="my-0 mt-1"><label for="email">E-Mail Address <b class="text-red">*</b></label></h3>
    <input id="email" type="email" name="email" placeholder="example@email.com" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <h3 class="my-0 mt-1"><label for="password">Password <b class="text-red">*</b></label></h3>
    <input id="password" type="password" name="password" placeholder="New Password"  required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <h3 class="my-0 mt-1"><label for="password-confirm">Confirm Password <b class="text-red">*</b></label></h3>
    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Repeat Password" required>
    <button class="button" type="submit"> Register </button>
</form>
@endsection