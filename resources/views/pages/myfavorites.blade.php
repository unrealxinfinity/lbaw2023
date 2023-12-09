@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
    <section id="myfavorites">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myfavorites">Favorites</a></p>
        @if(count($worlds) > 0 || count($projects) > 0)
            @if(count($worlds) > 0)
                <h1 class="mt-5">Favorite Worlds</h1>
                @each('partials.myworlds', $worlds, 'world')
            @endif
            @if(count($projects) > 0)
                <h1 class="mt-5">Favorite Projects</h1>
                @each('partials.myprojects', $projects, 'project')
            @endif
        @else
        <h1 class="mobile:m-10 m-5">Nothing to see here yet.. <br> Try adding something to your favorites!</h1>
        @endif
    </section>
@endsection