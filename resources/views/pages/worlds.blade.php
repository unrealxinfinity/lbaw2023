@extends('layouts.app')

@section('title', 'Worlds')

@section('content')

    <section id="worlds" class="md:flex justify-start">
    <input type="checkbox" id="show-details" class="hidden peer"/>
    @foreach ($worlds as $world)
        @include('partials.world', ['world' => $world])
    @endforeach

@endsection