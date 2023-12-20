@extends('layouts.app')

@section('title', 'Invites')

@section('content')
    <section id="invites">
        <p><a href="/">Home</a> > <a href="/members/{{Auth::User()->username}}">{{Auth::User()->username}}</a> > <a href="/invites">Invites</a></p>
        <h1 class="mt-4 mb-4">Invites</h1>
        @if (count($invites) !== 0)
            <h2 class="border-t border-gray-400 pt-4">World Invites</h2>
            @foreach($invites as $invite)
                @include('partials.invites', ['invite' => $invite, 'type' => 'invite'])
            @endforeach
        @endif
        @if(count($friend_requests) !== 0)
            <h2 class="border-t border-gray-400 pt-4">Friend Requests</h2>
            @foreach($friend_requests as $request)
                @include('partials.invites', ['request' => $request, 'type' => 'request'])
            @endforeach
        @endif
        @if(count($friend_requests) === 0 && count($invites) === 0)
            <p>You have no invites.</p>
        @endif
    </section>
@endsection