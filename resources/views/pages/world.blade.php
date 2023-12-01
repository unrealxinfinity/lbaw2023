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
@endsection