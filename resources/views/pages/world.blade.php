@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <section id="worlds" class="md:flex justify-start">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.world', ['world' => $world])
        <div class="md:hidden fixed bg-opacity-95 bg-black text-white top-28 h-full w-0 right-0 peer-checked:w-full peer-checked:pl-5 transition-width duration-500 overflow-hidden z-10">
            @include('partials.sidebar', ['thing'=>$world, 'type' => 'world'])
        </div>
        <div class="hidden md:contents">
        @include('partials.sidebar', ['thing'=>$world, 'type' => 'world'])
        </div>
    </section>
    @if ($subform)
    <div id="edit-world" class="fixed z-10 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-center">
        <div class="bg-black md:w-3/4 md:h-4/5 h-full rounded drop-shadow md:mx-auto">
            <div class="flex"> 
            <h1 class="mt-3 ml-5"> {{ $formTitle }} </h1>
            <a id="go-back" class="cursor-pointer sm:text-big text-bigPhone fixed right-5 mt-1">&times;</a>
            </div>
            @include($formName, ['world'=>$world])
        </div>
    </div>
    @endif
@endsection