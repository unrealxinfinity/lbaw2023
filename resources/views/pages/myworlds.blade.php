@extends('layouts.app')

@section('title', 'My Worlds')

@section('content')

    <section id="myworlds">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/myworlds">Worlds</a></p>
        <h1>My Worlds</h1>
        <div>
            @each('partials.myworlds', $worlds, 'world')
        </div>
    </section>
@endsection

