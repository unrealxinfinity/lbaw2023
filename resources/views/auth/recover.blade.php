@extends('layouts.app')

@section('title', 'Recover password')

@section('content')
<form method="POST" class="form-post first-letter" action="{{ route('send-recover') }}">
    @csrf

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif
    <button class="button w-1/4" type="submit"> Recover Password </button>
</form>
@endsection