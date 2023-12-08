@extends('layouts.app')

@section('title', 'Accept Invite')

@section('content')
    @if(Auth::check() && Auth::user()->username == $username)
        @include('partials.invite')
    @else
        <h1>Error: Not logged in or not the same user</h1>
    @endif
@endsection
