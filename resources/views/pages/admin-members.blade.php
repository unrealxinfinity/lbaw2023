@extends('layouts.app')

@section('title', 'Administer members')

@section('content')
    <p><a href="/">Home</a> > <a href="/admin">Admin</a></p>
    <h1>Manage members</h1>
    <form method="GET" action="/admin">
        <input type="text" name="search" placeholder="Search by email/username" required>
        <input type="submit" value="Search">
    </form>
    <section id="members">
        @each('partials.member-edit', $members, 'member')
        @include('form.createaccount')
    </section>
@endsection