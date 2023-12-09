@extends('layouts.app')

@section('title', 'My Projects')

@section('content')

    <section id="myprojects">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myprojects">Projects</a></p>
        @if(count($projects) > 0)
            <h1 class="mt-5">My Projects</h1>
            @each('partials.myprojects', $projects, 'project')
        @else
            <h1 class="mobile:m-10 m-5">You don't belong to any project yet..</h1>
        @endif
    </section>
@endsection