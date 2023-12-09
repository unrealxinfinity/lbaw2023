@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <section id="worlds" class="desktop:flex">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.world', ['world' => $world])
        <div class="desktop:hidden fixed bg-opacity-95 bg-black top-0 h-full w-0 right-0 mobile:peer-checked:w-2/3 tablet:peer-checked:w-1/2 peer-checked:w-full peer-checked:px-5 transition-width duration-500 z-10">
            @include('partials.sidebar', ['thing'=>$world, 'type' => 'world'])
        </div>
        <div class="hidden desktop:contents">
            @include('partials.sidebar', ['thing'=>$world, 'type' => 'world'])
        </div>
    </section>
    @if ($subform)
    <div id="edit-world" class="fixed z-10 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-center">
        <div class="bg-black tablet:w-3/4 tablet:h-4/5 h-full rounded drop-shadow tablet:mx-auto">
            <div class="flex"> 
            <h1 class="mt-3 ml-5"> {{ $formTitle }} </h1>
            <a id="go-back" class="cursor-pointer sm:text-big text-bigPhone fixed right-5 mt-1">&times;</a>
            </div>
            @include($formName, ['world'=>$world])
        </div>
    </div>
    @endif
@endsection