@extends('layouts.app')

@section('title', 'About')

@section('content')

    <section id="about" class="flex mobile:flex-row flex-col items-center justify-center px-3 py-2 mobile:mt-10">
            <img class="mobile:mr-4 mb-5 mobile:w-1/6 w-1/4" src="{{ URL('/images/steve-crafting.png') }}" alt="">
            <div class="bg-white rounded-lg mobile:p-5 p-2 w-full">
                <h2 class="rounded-lg p-2 text-black">MineMax is a project management tool to help Minecraft players better organize their Worlds and Projects.<br>
                    <br>
                    Our mission is to help Minecraft players to better idealize and organize their projects and have an easy way to look back past the progress they've made. Knowing boredom out of not knowing what to do next is a major problem while playing Minecraft Survival, we seek to help people have more fun and stay engaged during gameplay!<br>                
                    <br>
                    The team behind MineMax is composed of 4 students from the University of Porto:<br> <a href="/contacts" class="text-green/70 hover:underline">Afonso Vaz Osório, Isabel Moutinho, Tiago Cruz, HaoChang Fu</a></h2>
            </div>
            
    </section>

@endsection