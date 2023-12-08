@extends('layouts.app')

@section('title', 'Worlds')

@section('content')
    <p><a href="/">Home</a> > <a href="/worlds"> Worlds</a></p>
    <form action="/worlds" METHOD="GET">
        <input type="text" name="search" placeholder="Search by name">
        <input class="button" type="submit" value="Search">
    </form>
    <section id="worlds">
        @each('partials.myworlds', $worlds, 'world')
    </section>

@endsection