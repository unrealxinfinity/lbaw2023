@extends('layouts.app')

@section('title', 'invite')

@section('content')
    @if ($invites && count($invites) !== 0)
        <section id="invites">
            <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/invites">Invites</a></p>
            <h1>Invites</h1>
            @each('partials.invite' , $invites, 'invite')
        </section>
    @else
        <section id="invites">
            <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/invites">Invites</a></p>
            <h1>Invites</h1>
            <p>You have no invites.</p>
        </section>
    @endif
    
@endsection