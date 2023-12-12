@extends('layouts.app')

@section('title', $project->name)


@section('content')
    <section id="projects" class="desktop:flex">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.project', ['project' => $project, 'tags' => $tags])
        <div class="desktop:hidden fixed bg-opacity-95 bg-black top-0 h-full w-0 right-0 mobile:peer-checked:w-2/3 tablet:peer-checked:w-1/2 peer-checked:w-full peer-checked:px-5 transition-width duration-500 z-10">
            @include('partials.sidebar', ['thing'=>$project, 'type' => 'project'])
        </div>
        <div class="hidden desktop:contents">
            @include('partials.sidebar', ['thing'=>$project, 'type' => 'project'])
        </div>
    </section>
    @if ($edit)
    <div id="edit-project" class="fixed z-30 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-center">
        <div class="bg-black tablet:w-3/4 tablet:h-fit h-full tablet:rounded drop-shadow tablet:mx-auto">
            <div class="flex my-3">
                <h1 class="mt-3 ml-5"> Edit Project </h1>
                <h1><a id="go-back" class="cursor-pointer fixed right-5 mt-1">&times;</a></h1>
                </div>
                @include('form.project-edit', ['project'=>$project])
            </div>
        </div>
    </div>
    @endif
@endsection