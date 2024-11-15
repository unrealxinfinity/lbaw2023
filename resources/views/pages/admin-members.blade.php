@extends('layouts.app')

@section('title', 'Member Management')

@section('content')
    <a href="#admin-create-account" class="sr-only sr-only-focusable">Create an Account</a>
    <a href="#admin-manage-members" class="sr-only sr-only-focusable">Manage Members</a>

    <p><a href="/">Home</a> > <a href="/admin/members">Member Management</a></p>
    <h1 class="my-2" id="admin-manage-members">Manage members</h1>
    <form method="GET" action="/admin">
        <fieldset>
            <legend>Search Members</legend>
            <h3 class="my-0 mt-3"> <label for="search-members">Search</label> </h3>
            <input type="text" name="search" id="search-members" placeholder="Search by email/username" required>
            <input class="button" type="submit" value="Search">
        </fieldset>
    </form>
    <section id="members">
        <div class="my-5 px-5 py-1 bg-black/50 outline outline-1 outline-white/10">
            <div class="my-5">{{ $members->links() }}</div>
            @each('partials.member-edit', $members, 'member')
            <div class="my-5">{{ $members->links() }}</div>
        </div>
        <h2 class="my-2" id="admin-create-account"> Create an account </h2>
        @include('form.createaccount')
    </section>
@endsection