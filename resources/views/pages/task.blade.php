@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <section id="flags" class="md:flex justify-between">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.task', ['task' => $task])
        <div class="md:hidden fixed bg-opacity-95 bg-black text-white top-28 h-full w-0 right-0 peer-checked:w-full peer-checked:pl-5 transition-width duration-500 overflow-hidden z-10">
            @include('partials.task-details', ['task' => $task])
        </div>
        <div class="hidden md:contents">
            @include('partials.task-details', ['task' => $task])
        </div>
    </section>
@endsection