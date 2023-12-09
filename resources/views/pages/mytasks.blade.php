@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')

    <section id="mytasks">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/mytasks">Tasks</a></p>
        @if(count($tasks) > 0)
            <h1 class="mt-5">My Tasks</h1>
            @each('partials.mytasks', $tasks, 'task')
        @else
            <h1 class="mobile:m-10 m-5">You aren't assigned to any task yet..</h1>
        @endif
    </section>
@endsection