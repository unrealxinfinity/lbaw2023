@extends('layouts.app')


@section('title', 'Search')

@section('content')
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    @if ($member)
        <form method="GET" class="mobile:flex mobile:justify-end grid grid-flow-row mobile:child:mx-2 child:my-0.5 mb-2 mobile:mx-0 mx-3" data-id="{{ $member->id }}" action="{{ route('search') }}">
            @csrf
            <input type="text" class="mobile:hidden" id="anything" name="anything" value="{{$search}}" required>
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <select id="typeFilter" name="typeFilter">
                <option value="{{ $type }}" selected>{{ $type }}</option>
                @if($type!="All")<option value="All">All</option>@endif
                @if($type!="World")<option value="World">World</option>@endif
                @if($type!="Project")<option value="Project" >Project</option>@endif
                @if($type!="Task")<option value="Task">Task</option>@endif
                @if($type!="Member")<option value="Member">Member</option>@endif
            </select>
            <input type="text" id="Tags" name="tags" placeholder="tag1,tag2"> 
            <select id="order" name="order">
                <option value= "{{ $order }}" selected>{{ $order }}</option>
                @if($order!="Relevance")<option value= "Relevance">Relevance</option>@endif
                @if($order!="A-Z")<option value="A-Z">A-Z</option>@endif
                @if($order!="Z-A")<option value="Z-A">Z-A</option>@endif
            </select>
            <input class="button" type="submit" id="mainSearchButton" value='Filter'>
        </form>
        @if(count($tasks) > 0 || count($projects) > 0 || count($worlds) > 0 || count($members) > 0)
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
                <h1 class="mt-5"> Members </h1>
                @foreach($members as $otherMember)
                <header class="myworld flex h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded">
                    <img src= {{$otherMember->getProfileImage()}} alt="{{$otherMember->persistentUser->user->username}} profile picture" class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
                    <div class="flex flex-col self-center ml-3 w-11/12">
                    <h2 class="break-words"><a href="/members/{{ $otherMember->persistentUser->user->username }}">{{ $otherMember->name }}</a></h2>
                    <h3 class="break-words"> @ {{ $otherMember->persistentUser->user->username }}</h3>
                    <h4 class="pt-2 break-words">{{ $otherMember->description }}</h4>
                    </div>
                    @can('request', $otherMember)
                        <a class="friend-button justify-self-end" href="/api/request/{{ $otherMember->persistentUser->user->username }}">&#10010;</a>
                    @endcan
                </header>
                @endforeach
            @endif
        @else
            <h1 class="mobile:m-10 m-5"> No results for "{{$search}}" <br> Try searching for something else </h1>
        @endif
    @endif
@endsection

