@extends('layouts.app')

@section('title', 'Administer members')

@section('content')
    <form method="GET" action="/admin">
        <input type="text" name="search" placeholder="Search by email/username">
        <input type="submit" value="Search">
    </form>
    <section id="members">
        @each('partials.member-edit', $members, 'member')
    </section>
@endsection