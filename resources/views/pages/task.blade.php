@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <section id="tags" class="desktop:flex">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.task', ['task' => $task])
        <div class="desktop:hidden fixed bg-opacity-95 bg-black top-0 h-full w-0 right-0 mobile:peer-checked:w-2/3 tablet:peer-checked:w-1/2 peer-checked:w-full peer-checked:px-5 transition-width duration-500 z-10">
            @include('partials.task-details', ['task' => $task])
        </div>
        <div class="hidden desktop:contents">
            @include('partials.task-details', ['task' => $task])
        </div>
    </section>
@endsection