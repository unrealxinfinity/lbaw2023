@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <section id="worlds">
        @include('partials.world', ['world' => $world])
        @include('partials.sidebar', ['thing'=>$world])
    </section>
@endsection