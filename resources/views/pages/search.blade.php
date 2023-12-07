@extends('layouts.app')


@section('title', 'search')

@section('content')
    @php
        $member = Auth::user() ? Auth::user()->persistentUser->member : null;
    @endphp
    @if ($member)
        <form method="GET" class="flex justify-end child:mx-2" data-id="{{ $member->id }}" action="{{ route('search') }}">
            @csrf
            <input type="hidden" id="anything" name="anything" value="{{$search}}" required>
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <select id="typeFilter" name="typeFilter">
                <option value="{{ $type }}" selected>{{ $type }}</option>
                @if($type!="All")<option value="All">All</option>@endif
                @if($type!="World")<option value="World">World</option>@endif
                @if($type!="Project")<option value="Project" >Project</option>@endif
                @if($type!="Task")<option value="Task">Task</option>@endif
                @if($type!="Member")<option value="Member">Member</option>@endif
            </select>
            <select id="order" name="order">
                <option value= "{{ $order }}" selected>{{ $order }}</option>
                @if($order!="Relevance")<option value= "Relevance">Relevance</option>@endif
                @if($order!="A-Z")<option value="A-Z">A-Z</option>@endif
                @if($order!="Z-A")<option value="Z-A">Z-A</option>@endif
            </select>
            <input class="button" type="submit" id="mainSearchButton" value='Filter'>
        </form>
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
                <img src= {{$member->getProfileImage()}} class=" h-16 aspect-square mt-5 ml-5">
                <div class="flex flex-col ml-5">
                <h1 class="text-white mb-0">{{ $member->name }}</h1>
                <h2 class="pl-3"> @ {{ $member->persistentUser->user->username }}</h2>
                <h2 class="pl-3">{{ $member->description }}</h2>
                </div>
            </header>
            @endforeach
        @endif
    @endif
@endsection

