@extends('layouts.app')

@section('content')
<form method="POST" class="form-post" action="{{ route('reset-password') }}">
    @csrf

    <input type="hidden" name="member" value="on">

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
</form>
@endsection