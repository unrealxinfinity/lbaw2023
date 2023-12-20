@extends('layouts.app')

@section('title', 'FAQs')

@section('content')

    <section id="Faqs" class="flex flex-col items-center justify-start h-screen bg-gray-100 p-10">
        <div class="flex items-center justify-center w-full">
            <img class="mr-0 p-0 w-2/6 " src="{{ URL('/images/confused-steve.png') }}" alt="Minecraft player model with a 'Steve' skin, holding a picaxe in his right hand and confused">
            <div class="flex flex-col items-center justify-center bg-white rounded-lg py-4 px-9 w-auto h-auto" >
                <h1 class="text-4xl font-bold text-black">FAQs</h1>
                @foreach($faqs as $faq)
                <details class="flex flex-col items-center justify-center w-full" id="faqContainer">
                    <summary class="flex flex-row text-lg font-semibold text-black bg-lime py-4 px-6 m-2 rounded-lg cursor-pointer transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:shadow-outline ">
                        <div class="mx-4">{{ $faq->question }}</div>
                        @if(Auth::check() && Auth::user()->persistentUser->type_ == 'Administrator')
                            @include('form.faq', ['faq' => $faq , 'operation'=>'delete'])
                        @endif
                    </summary>
                    <h2 class="text-black bg-lime bg-opacity-50 rounded-lg px-5 py-4 flex items-center w-full mx-auto">
                        {{ $faq->answer }}
                    </h2>
                </details>
                @endforeach
                @if(Auth::check() && Auth::user()->persistentUser->type_ == 'Administrator')
                            @include('form.faq', ['operation'=>'add'])
                @endif
            </div>
            
        </div>
        
    </section>

@endsection