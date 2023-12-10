@extends('layouts.app')

@section('title', 'Invites')

@section('content')
    <section id="invites">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/invites">Invites</a></p>
        <h1 class="mt-4">Invites</h1>
        @if (count($invites) !== 0)
            @each('partials.invites' , $invites, 'invite')
        @else
            <p>You have no invites.</p>
        @endif
    </section>
@endsection