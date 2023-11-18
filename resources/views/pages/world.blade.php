@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <section id="worlds">
        @include('partials.world', ['world' => $world])
    </section>
    <a class="button" href="/worlds/{{ $world->id }}/create-project">Create Project</a>
@endsection