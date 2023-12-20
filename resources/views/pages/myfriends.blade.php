@extends('layouts.app')

@section('title', 'My Friends')

@section('content')

    <section id="myfriends">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myfriends">Friends</a></p>
        @if(count($friends) > 0)
            <h1 class="mt-5">My Friends</h1>
            @each('partials.friend', $friends, 'friend')
        @else
            <h1 class="mobile:m-10 m-5">You don't have friends yet.. <br> Try making some!</h1>
        @endif
    </section>
@endsection

