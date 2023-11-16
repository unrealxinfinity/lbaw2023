@extends('layouts.app')

@section('title', $project->name)


@section('content')
    <section id="projects">
        @include('partials.project', ['project' => $project, 'main' => true])
    </section>
    <section id="add_task_form">
        <form id = "new-task">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input type="text" name="title" placeholder="Title">
            <input type="text" name="description" placeholder="Description">
            <input type="text" name="status" placeholder="Status">
            <input type="date" name="due_at" placeholder="Due Date">
            <input type="number" name="effort" placeholder="Effort">
            <input type="text" name="priority" placeholder="Priority">
            <button type="submit">Create Task</button>
        </form>
    </section>
@endsection