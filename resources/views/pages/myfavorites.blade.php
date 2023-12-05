@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')

    <section id="myfavorites">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myfavorites">Favorites</a></p>
        <h1>Favorite Worlds</h1>
        @each('partials.myworlds', $worlds, 'world')
        <h1>Favorite Projects</h1>
        @each('partials.myprojects', $projects, 'project')
    </section>
@endsection