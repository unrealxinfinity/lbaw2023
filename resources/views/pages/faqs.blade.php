@extends('layouts.app')

@section('title', 'FAQs')

@section('content')

    <section id="Faqs" class="flex flex-col items-center justify-start h-screen bg-gray-100 p-10">
        <div class="flex items-center justify-center w-full">
            <img class="mr-4 w-1/6" src="{{ URL('/images/confused-steve.png') }}" alt="Minecraft player model with a 'Steve' skin, holding a picaxe in his right hand and confused">
            <div class="flex flex-col items-center justify-center">
                <h1 class="text-4xl font-bold">FAQs</h1>
                @foreach($faqs as $faq)
                    <div class="flex flex-col items-center justify-center w-full">
                        <h2 class="text-2xl font-bold">{{ $faq->question }}</h2>
                        <p class="text-xl">{{ $faq->answer }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        
    </section>

@endsection