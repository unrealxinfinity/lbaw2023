@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<form method="POST" class="form-outline" action="{{ route('reset-password') }}">
  <fieldset class="form-post">
    <legend>Reset Password</legend>
    @csrf

    <input type="hidden" name="token" value={{ $token }}>
    <input type="hidden" name="id" value={{ $id }}>

    <label for="password">New Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>
    <button class="button" type="submit"> Reset Password </button>
  </fieldset>
</form>
@endsection