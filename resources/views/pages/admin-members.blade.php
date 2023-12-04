@extends('layouts.app')

@section('title', 'Administer members')

@section('content')
    <p><a href="/">Home</a> > <a href="/admin">Admin</a></p>
    <h1>Manage members</h1>
    <form method="GET" action="/admin">
        <input type="text" name="search" placeholder="Search by email/username" required>
        <input class="button" type="submit" value="Search">
    </form>
    <section id="members">
        @each('partials.member-edit', $members, 'member')
        <div class="flex ml-auto mr-auto">
            <a href="#" class="button">
              Previous
            </a>
          
            <a href="#" class="button">
              Next
            </a>
          </div>
        @include('form.createaccount')
    </section>
@endsection