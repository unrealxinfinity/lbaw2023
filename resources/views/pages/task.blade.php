@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <a href="#comments" class="sr-only sr-only-focusable">Comments</a>
    <a href="#make-comment-task" class="sr-only sr-only-focusable">Make a Comment</a>
    @can('edit', $task)
        <a href="#edit-task-details" class="sr-only sr-only-focusable">Edit Task Details</a>
        <a href="#members-assigned" class="sr-only sr-only-focusable">See assigned members to task</a>
        @if ($task->status != 'Done')
            <a href="#assign-new-member" class="sr-only sr-only-focusable">Assign Member to Task</a>
        @endif
    @else
        <a href="#task-see-details" class="sr-only sr-only-focusable">See task details</a>

    @endcan

    <section id="task" class="desktop:flex">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.task', ['task' => $task])
        <div class="desktop:hidden fixed bg-opacity-95 bg-black top-0 h-full w-0 right-0 mobile:peer-checked:w-2/3 tablet:peer-checked:w-1/2 peer-checked:w-full peer-checked:px-5 transition-width duration-500 z-10">
            @include('partials.task-details', ['task' => $task, 'prefix' => 'mobile-'])
        </div>
        <div class="hidden desktop:contents">
            @include('partials.task-details', ['task' => $task, 'prefix' => ''])
        </div>
    </section>
@endsection