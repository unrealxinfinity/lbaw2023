@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <section id="worlds">
        @include('partials.world', ['world' => $world])
    </section>
    <button type="button" href="{{ route('project-create', ['id', $world->id]) }}">Create Project</button>
@endsection