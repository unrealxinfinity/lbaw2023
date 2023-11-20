@extends('layouts.app')


@section('title', 'search')

@section('content')
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    
    @if ($member)
        <section id="homepage">
            @include('partials.homepage', ['member' => $member, 'tasks' =>$tasks , 'projects' => $projects, 'worlds' => $worlds, 'main' => false])
        </section>
        @if(count($members) > 0)
        <h2> Members </h2>
            @foreach($members as $otherMember)
                <article class="myworld" data-id="{{ $otherMember->id }}">
                    <header>
                        <div class="row">
                            <img src={{$otherMember->picture}} class="big">
                            <div class="column">
                                <h2><a href="/members/{{ $otherMember->username }}">{{ $otherMember->username }}</a></h2>
                                <h4> {{ $otherMember->description }} </h4>
                            </div>
                        </div>
                    </header>
                </article>
            @endforeach
        @endif
    @endif
@endsection

