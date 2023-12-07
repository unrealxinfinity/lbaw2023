@extends('layouts.app')

@section('title', 'invite')

@section('content')
    <section id="myworlds">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/invites">Invites</a></p>
        <h1>Invites</h1>
        @each('partials.invite' , $invites, 'invite')
    </section>
@endsection