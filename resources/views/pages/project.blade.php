@extends('layouts.app')

@section('title', $project->name)


@section('content')
    <section id="projects">
        @include('partials.project', ['project' => $project])
    </section>
    <section id="create-task">
        @include('partials.task-create', ['project' => $project])
    </section>
@endsection