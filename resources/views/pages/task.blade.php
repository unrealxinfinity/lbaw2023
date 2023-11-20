@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <section class="flags">
        @include('partials.task', ['task' => $task, 'main' => true])
        <div class="div"> </div>
        @include('partials.task-details', ['task' => $task])
    </section>
@endsection