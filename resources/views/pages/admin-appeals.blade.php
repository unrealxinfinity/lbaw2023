@extends('layouts.app')

@section('title', 'Appeal Management')

@section('content')
    <p><a href="/">Home</a> > <a href="{{ route('admin-appeals') }}">Appeal Management</a></p>
    <h1 class="my-2">Manage appeals</h1>
    <form method="GET" action="/appeals">
        <fieldset>
            <legend>Search Members</legend>
            <h3 class="my-0 mt-3"> <label for="search-appeal">Search</label></h3>
            <input type="text" name="search" id="search-appeal" placeholder="Search by email/username" required>
            <input class="button" type="submit" value="Search">
        </fieldset>
    </form>
    <section id="appeals">
        <div class="my-5 px-5 py-1 bg-black/50 outline outline-1 outline-white/10">
            <div class="my-5">{{ $appeals->links() }}</div>
            @each('partials.appeal', $appeals, 'appeal')
            <div class="my-5">{{ $appeals->links() }}</div>
        </div>
    </section>
@endsection