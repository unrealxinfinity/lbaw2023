@extends('layouts.app')

@section('title', 'Recover password')

@section('content')
<form method="POST" class="form-outline first-letter" action="{{ route('send-recover') }}">
  <fieldset class="form-post">
    <legend>Recover your password</legend>
    @csrf

    <label for="email">Email</label> <br> 
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full" tabindex="0">
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif
    <br> <br>
    <button class="button w-1/4" type="submit"> Recover Password </button>
  </fieldset>
</form>
@endsection