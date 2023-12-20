@extends('layouts.app')

@section('title', 'FAQs')

@section('content')

<section id="faqs" class="flex mobile:flex-row flex-col items-center px-3 py-2 mobile:mt-5">
        <img class="mb-5 mobile:w-1/4 w-1/2" src="{{ URL('/images/confused-steve.png') }}" alt="Minecraft player model with a 'Steve' skin, holding a picaxe in his right hand and confused">
        <div class=" bg-white rounded-lg p-2 w-full">
            <h1 class="font-bold text-black m-2">FAQs</h1>
            @foreach($faqs as $faq)
                <details id="faqContainer">
                    <summary class="flex child:text-black items-center bg-lime p-3 py-5 m-2 rounded-lg cursor-pointer transition duration-300 hover:scale-105">
                        <h2 class="font-semibold">{{ $faq->question }}</h2>
                        @if(Auth::check() && Auth::user()->persistentUser->type_ == 'Administrator')
                            @include('form.faq', ['faq' => $faq , 'operation'=>'delete'])
                        @endif
                    </summary>
                    <h2 class="text-black bg-lime/50 rounded-lg p-4">
                        {{ $faq->answer }}
                    </h2>
                </details>
            @endforeach
            @if(Auth::check() && Auth::user()->persistentUser->type_ == 'Administrator')
                @include('form.faq', ['operation'=>'add'])
            @endif
        </div>
</section>



@endsection