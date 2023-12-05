@extends('layouts.app')

@section('title', 'invite')

@section('content')
    @if(Auth::check() && Auth::user()->username == request('username'))
        @include('partials.invite')
    @else
        <h1>Error: Not logged in or not the same user</h1>
    @endif
@endsection
