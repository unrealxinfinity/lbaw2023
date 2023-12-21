@extends('layouts.app')

@section('title', 'Main Features')

@section('content')

    <section id="main-features" class="flex mobile:flex-row flex-col items-center justify-center px-3 py-2 mobile:mt-10">
        <img class="mobile:mr-4 mb-5 mobile:w-1/6 w-1/4" src="{{ URL('/images/alex-tnt.png') }}" alt="">
        <div class="bg-white rounded-lg shadow-lg p-2 w-2/4">
            <h1 class="text-black bold">Welcome to MineMax, a minecraft world project management tool. Here you can:</h1>
            <ul class="list-disc pl-5 text-black">
                <li> Create your own worlds, projects and tasks!</li>
                <li> Invite friends to your worlds!</li>
                <li> Costumize your profile!</li>
                <li> Use your Minecraft head skin as the profile picture by only typing your Minecraft username!</li>
                <li> Add tags to your world/projects to let the community know what they're are about!</li>
                <li> Add tags to your profile to let the community know what you're interested in!</li>
                <li> Search for worlds/projects/tasks to inspire yourself!</li>
                <li> Be notified when your task is close to the deadline!</li>
            </ul>
        </div>
    </section>

@endsection