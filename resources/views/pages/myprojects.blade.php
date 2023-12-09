@extends('layouts.app')

@section('title', 'My Projects')

@section('content')

    <section id="myprojects">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myprojects">Projects</a></p>
        <h1 class="mt-5">My Projects</h1>
        @each('partials.myprojects', $projects, 'project')
    </section>
@endsection