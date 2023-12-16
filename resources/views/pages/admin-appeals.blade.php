@extends('layouts.app')

@section('title', 'Appeal Management')

@section('content')
    <p><a href="/">Home</a> > <a href="/appeals">Admin</a></p>
    <h1 class="my-2">Manage members</h1>
    <form method="GET" action="/appeals">
        <input type="text" name="search" placeholder="Search by email/username" required>
        <input class="button" type="submit" value="Search">
    </form>
    <section id="appeals">
        <div class="my-5 px-5 py-1 bg-black/50 outline outline-1 outline-white/10">
            <div class="my-5">{{ $appeals->links() }}</div>
            @each('partials.appeal', $appeals, 'appeal')
            <div class="my-5">{{ $appeals->links() }}</div>
        </div>
    </section>
@endsection