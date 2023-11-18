@extends('layouts.app')


@section('title', 'home')

@section('content')
    <section id="homepage">
        <h1>Welcome to MineMax!</h1>
        <p>Here you can manage your Worlds and Projects.</p>
        @unless (Auth::check()) <p>Log in to get started!</p> @endunless
    </section>
    @if (Auth::check() && Auth::user()->persistentUser->member)
        <section id="homepage">
            @include('partials.homepage', ['member' => Auth::user()->persistentUser->member])
        </section>
    @endif
    @if (Auth::check() && Auth::user()->persistentUser->type_=='Administrator')
        <section id="homepage">
            <a href="/admin" class="button">Admin Page</a>
        </section>
    @endif
        
    
@endsection

