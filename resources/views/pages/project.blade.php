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
    <script>
        document.body.style.overflow = 'hidden';
    </script>
    <div id="edit-project" class="fixed z-30 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-around">
        <div class="bg-black tablet:w-3/4 tablet:min-h-fit tablet:max-h-[90%] h-full w-full tablet:rounded tablet:mx-auto">
            <div class="flex justify-between mx-5 pt-3">
                <h1> Edit Project </h1>
                <h1><a id="go-back" class="cursor-pointer">&times;</a></h1>
                </div>
                <div class="overflow-auto tablet:min-h-fit tablet:max-h-[90%] h-[90%]">
                    @include('form.project-edit', ['project'=>$project])
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection