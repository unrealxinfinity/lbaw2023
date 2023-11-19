@extends('layouts.app')


@section('title', 'home')

@section('content')
    <section id="homepage">
        <h1>Welcome to MineMax!</h1>
        <p>Here you can manage your Worlds and Projects.</p>
        @unless (Auth::check()) <p>Log in to get started!</p> @endunless
    </section>
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    
    @if ($member)
        @include('form.main-search',['member'=>$member])
        <section id="homepage">
            @include('partials.homepage', ['member' => $member, 'tasks' => $member->tasks()->orderBy('id')->get(), 'projects' => $member->projects()->where('status', '=', 'Active')->orderBy('id')->get(), 'worlds' => $member->worlds()->orderBy('id')->get()])
        </section>
    @endif
    @if (Auth::check() && Auth::user()->persistentUser->type_=='Administrator')
        <section id="homepage">
            <a href="/admin" class="button">Admin Page</a>
        </section>
    @endif
        
    
@endsection

