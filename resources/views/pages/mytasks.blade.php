@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')

    <section id="mytasks">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/mytasks">Tasks</a></p>
        <h1>My Tasks</h1>
        @each('partials.mytasks', $tasks, 'task')
    </section>
@endsection