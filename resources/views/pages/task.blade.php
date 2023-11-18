@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <section id="tasks">
        @include('partials.task', ['task' => $task, 'main' => true])
    </section>
@endsection