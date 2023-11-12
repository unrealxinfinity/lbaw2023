@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <section id="worlds">
        @include('partials.world', ['world' => $world])
    </section>
@endsection