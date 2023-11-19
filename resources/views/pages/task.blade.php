@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <section id="tasks">
        @include('partials.task', ['task' => $task, 'main' => true])
        @include('partials.task-details', ['task' => $task])
    </section>
@endsection