@extends('layouts.app')

@section('title', 'My Worlds')

@section('content')

    <section id="myworlds">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myworlds">Worlds</a></p>
        @if(count($worlds) > 0)
            <h1 class="mt-5">My Worlds</h1>
            @each('partials.myworlds', $worlds, 'world')
        @else
            <h1 class="mobile:m-10 m-5">You don't belong to any world yet.. <br> Try creating one!</h1>
        @endif
    </section>
@endsection

