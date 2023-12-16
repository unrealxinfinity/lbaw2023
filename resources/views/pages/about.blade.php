@extends('layouts.app')

@section('title', 'About')

@section('content')

    <section id="About" class="flex flex-col items-center justify-start h-screen bg-gray-100 p-10">
        <div class="flex items-center justify-center w-full">
            <img class="mr-4 w-1/6" src="{{ URL('/images/steve-crafting.png') }}" alt="Minecraft player model with a 'Steve' skin, holding a wood planks block with both his hands and a smirk on his face">
            <div class="bg-white rounded-lg shadow-lg p-10 w-2/4">
                <h2 class="mb-4 text-black">MineMax is a project management tool to help Minecraft players better organize their Worlds and Projects.</h2>
                <h2 class="mb-4 text-black">Our mission is to help Minecraft players to better idealize and organize their projects and have an easy way to look back past the progress they've made. Knowing boredom out of not knowing what to do next is a major problem while playing Minecraft Survival, we seek to help people have more fun and stay engaged during gameplay!</h2>
                <h2 class="text-black">The team behind MineMax is composed of 4 students from the University of Porto: <a href="/contacts" class="text-blue-500 hover:underline">Afonso Vaz Osório, Isabel Moutinho, Tiago Cruz, HaoChang Fu</a></h2>
            </div>
        </div>
    </section>

@endsection