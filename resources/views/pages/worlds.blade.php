@extends('layouts.app')

@section('title', 'Worlds')

@section('content')
    <p><a href="/">Home</a> > <a href="/worlds"> Worlds</a></p>
    <form action="/worlds" METHOD="GET">
        <fieldset>
            <legend>Search Worlds by Name</legend>
            <h3 class="my-0 mt-3"> <label for="search">Search:</label> </h3>
            <input type="text" name="search" id="search" placeholder="New Survival World">
    
            <label class="sr-only" for="submit-search">Search</label>
            <input class="button" type="submit" id="submit-search" value="Search">
        </fieldset>
    </form>
    <section id="worlds">
        {{ $worlds->links() }}
        @each('partials.myworlds', $worlds, 'world')
        {{ $worlds->links() }}
    </section>

@endsection