@extends('layouts.app')

@section('title', 'Home')

@section('content')
    
    @unless (Auth::check())
        <section id="homepage" class="h-screen mt-10 mx-5">
            <h1 class="text-center">Welcome to MineMax!</h1>
            <h2 class="text-center">Here you can manage your Worlds and Projects.</h2>
            <h2 class="text-center">Log in or Register to get started!</h2>
            <div class="w-full flex justify-center mt-5">
                <img src="{{ URL('/images/steve-alex-fly.png') }}" alt="Two minecraft player models, Steve, a man, on the left and Alex, a women, on the right, flying using the minecraft item 'elytra' that looks like wings on their back, both holding diamond swords">
            </div>
        </section>
    @endunless
    
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    
    @if ($member)
        @include('partials.homepage', ['member' => $member, 'tasks' => $member->tasks()->orderBy('id')->get(), 'projects' => $member->projects()->where('status', '=', 'Active')->orderBy('id')->get(), 'worlds' => $member->worlds()->orderBy('id')->get()])
    @endif
        
    
@endsection