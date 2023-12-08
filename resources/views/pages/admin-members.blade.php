@extends('layouts.app')

@section('title', 'Member Management')

@section('content')
    <p><a href="/">Home</a> > <a href="/admin">Admin</a></p>
    <h1>Manage members</h1>
    <form method="GET" action="/admin">
        <input type="text" name="search" placeholder="Search by email/username" required>
        <input class="button" type="submit" value="Search">
    </form>
    <section id="members">
        {{ $members->links() }}
        @each('partials.member-edit', $members, 'member')
        {{ $members->links() }}
        @include('form.createaccount')
    </section>
@endsection