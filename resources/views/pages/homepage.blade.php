@extends('layouts.app')


@section('title', 'home')

@section('content')
    <section id="homepage" class="mx-5">
        @unless (Auth::check())
        <h1>Welcome to MineMax!</h1>
        <p>Here you can manage your Worlds and Projects.</p>
        <p>Log in to get started!</p>
        @endunless
    </section>
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    
    @if ($member)
        @include('partials.homepage', ['member' => $member, 'tasks' => $member->tasks()->orderBy('id')->get(), 'projects' => $member->projects()->where('status', '=', 'Active')->orderBy('id')->get(), 'worlds' => $member->worlds()->orderBy('id')->get(), 'main' => true])
    @endif
    @if (Auth::check() && Auth::user()->persistentUser->type_=='Administrator')
        <a href="/admin" class="button">Admin Page</a>
    @endif
        
    
@endsection

