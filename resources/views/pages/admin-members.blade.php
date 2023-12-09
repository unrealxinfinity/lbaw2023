@extends('layouts.app')

@section('title', 'Member Management')

@section('content')
    <p><a href="/">Home</a> > <a href="/admin">Admin</a></p>
    <h1 class="my-2">Manage members</h1>
    <form method="GET" action="/admin">
        <input type="text" name="search" placeholder="Search by email/username" required>
        <input class="button" type="submit" value="Search">
    </form>
    <section id="members">
        <div class="my-5 px-5 py-1 bg-black/50 outline outline-1 outline-white/10">
            <div class="my-5">{{ $members->links() }}</div>
            @each('partials.member-edit', $members, 'member')
            <div class="my-5">{{ $members->links() }}</div>
        </div>
        <h2 class="my-2"> Create an account </h2>
        @include('form.createaccount')
    </section>
@endsection