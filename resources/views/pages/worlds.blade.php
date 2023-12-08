@extends('layouts.app')

@section('title', 'Worlds')

@section('content')
    <p><a href="/">Home</a> > <a href="/worlds"> Worlds</a></p>
    <section id="worlds">
        @each('partials.myworlds', $worlds, 'world')
    </section>

@endsection