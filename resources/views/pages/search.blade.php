@extends('layouts.app')


@section('title', 'Search')

@section('content')
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    
    @if ($member)
        @if(count($tasks) > 0)
            <h1> Tasks </h1>
            @foreach($tasks as $task)
                @include('partials.mytasks', ['task' => $task])
            @endforeach
        @endif
        @if(count($projects) > 0)
            <h1> Projects </h1>
            @foreach($projects as $project)
                @include('partials.myprojects', ['project' => $project])
            @endforeach
        @endif
        @if(count($worlds) > 0)
            <h1> Worlds </h1>
            @foreach($worlds as $world)
                @include('partials.myworlds', ['world' => $world])
            @endforeach
        @endif
            @if(count($members) > 0)
            <h1> Members </h1>
                @foreach($members as $otherMember)
                <header class="flex justify-start sm:h-28 h-24 bg-grey rounded m-5">
                    <img src= {{$otherMember->getProfileImage()}} class=" h-16 aspect-square mt-5 ml-5">
                    <div class="flex flex-col ml-5">
                    <h1 class="text-white mb-0">{{ $otherMember->name }}</h1>
                    <h2 class="pl-3"> @ {{ $otherMember->persistentUser->user->username }}</h2>
                    <h2 class="pl-3">{{ $otherMember->description }}</h2>
                    </div>
                    @can('request', $otherMember)
                        <a class="friend-button justify-self-end" href="/api/request/{{ $otherMember->persistentUser->user->username }}">&#10010;</a>
                    @endcan
                </header>
                @endforeach
        @endif
    @endif
@endsection

