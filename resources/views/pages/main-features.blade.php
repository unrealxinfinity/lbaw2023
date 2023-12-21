@extends('layouts.app')

@section('title', 'Main Features')

@section('content')

    <section id="main-features" class="flex mobile:flex-row flex-col items-center justify-center px-3 py-2 mobile:mt-10">
        <img class="mobile:mr-4 mb-5 mobile:w-1/6 w-1/4" src="{{ URL('/images/alex-tnt.png') }}" alt="">
        <div class="bg-white rounded-lg mobile:p-5 p-2 w-full text-black">
            <h1 class="text-black bold mt-3">Welcome to MineMax, a minecraft world project management tool.</h1>
            <br>
            <h1 class="text-black mobile:pl-5 pl-2"> Here you can: </h1>
            <ul class="list-disc mobile:pl-8 pl-4">
                <li> <h2 class="text-black"> Create your own worlds, projects and tasks!</h2> </li>
                <li> <h2 class="text-black"> Invite friends to your worlds!</h2> </li>
                <li> <h2 class="text-black"> Costumize your profile!</h2> </li>
                <li> <h2 class="text-black"> Use your Minecraft head skin as the profile picture by only typing your Minecraft username!</h2> </li>
                <li> <h2 class="text-black"> Add tags to your world/projects to let the community know what they're are about!</h2> </li>
                <li> <h2 class="text-black"> Add tags to your profile to let the community know what you're interested in!</h2> </li>
                <li> <h2 class="text-black"> Search for worlds/projects/tasks to inspire yourself!</h2> </li>
                <li> <h2 class="text-black"> Be notified when your task is close to the deadline!</h2> </li>
            </ul>
        </div>
    </section>

@endsection