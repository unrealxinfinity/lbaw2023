@extends('layouts.app')

@section('title', $project->name)


@section('content')
    <section id="projects">
        @include('partials.project', ['project' => $project, 'tags' => $tags])
        @include('partials.sidebar', ['thing'=>$project])
    </section>
    @if (Auth::user()->can('addMember', $project))
    <section id="add-member">
        @include('form.addmember', ['project' => $project])
    </section>
    <section id="create-task">
        @include('partials.task-create', ['project' => $project])
    </section>
    @endif
    @if (Auth::user()->persistentUser->member->projects->contains('id', $project->id))
    <section id="create-tag">
        @include('form.tag-create',['project'=> $project])
    </section>
    @endif
@endsection