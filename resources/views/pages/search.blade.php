@extends('layouts.app')


@section('title', 'search')

@section('content')
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    
    @if ($member)
        <section id="homepage">
            @include('partials.homepage', ['member' => $member, 'tasks' =>$tasks , 'projects' => $projects, 'worlds' => $worlds])
        </section>
        @foreach($members as $member)
            @include('partials.member', ['member' => $member, 'main' => true])
        @endforeach
    @endif
@endsection

