@extends('layouts.app')


@section('title', 'home')

@section('content')
    <section id="homepage">
        <h1>Welcome to MineMax!</h1>
        <p>Here you can manage your Worlds and Projects.</p>
        @unless (Auth::check()) <p>Log in to get started!</p> @endunless
    </section>
    @if (Auth::check())
        <a class="button" href="{{ url('members/' . Auth::user()->id) }}"> {{ Auth::user()->username }} </a>
    @endif
@endsection

