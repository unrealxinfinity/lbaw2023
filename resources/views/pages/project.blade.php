@extends('layouts.app')

@section('title', $project->name)


@section('content')
    <section id="projects">
        @include('partials.project', ['project' => $project, 'tags' => $tags])
        @include('partials.sidebar', ['thing'=>$project])
    </section>
    <section id="add-member">
        @include('form.addmember', ['project' => $project])
    </section>
    <section id="create-task">
        @include('partials.task-create', ['project' => $project])
    </section>
    <section id="create-tag">
        @include('form.tag-create',['project'=> $project])
    </section>
@endsection