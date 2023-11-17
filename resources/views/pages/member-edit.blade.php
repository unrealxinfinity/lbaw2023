@extends('layouts.app')

@section('title', $member->persistentUser->user->username)

@section('content')
    <form method="GET" action="/admin">
        <input type="text" name="search" placeholder="Search by email/username">
    </form>
    <section id="members">
        @include('partials-member-edit', ['member' => $member])
    </section>
    <h3> <a href = "/myworlds" >My Worlds</a></h3>
@endsection