@extends('layouts.app')

@section('title', 'Worlds')

@section('content')
    <p><a href="/">Home</a> > <a href="/worlds"> Worlds</a></p>
    <section id="worlds" class="md:flex justify-start">
        @foreach ($worlds as $world)
            @include('partials.myworlds', ['world' => $world])
        @endforeach
    </section>

@endsection