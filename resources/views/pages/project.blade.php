@extends('layouts.app')

@section('title', $project->name)


@section('content')
    <section id="projects" class="md:flex justify-start">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.project', ['project' => $project, 'tags' => $tags])
        <div class="md:hidden fixed bg-opacity-95 bg-black text-white top-28 h-full w-0 right-0 peer-checked:w-full peer-checked:pl-5 transition-width duration-500 overflow-hidden z-10">
            @include('partials.sidebar', ['thing'=>$project, 'type' => 'project'])
        </div>
        <div class="hidden md:contents">
            @include('partials.sidebar', ['thing'=>$project, 'type' => 'project'])
        </div>
    </section>
    @if ($edit)
    <div id="edit-project" class="fixed z-10 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-center">
        <div class="bg-black md:w-3/4 md:h-5/6 h-full rounded drop-shadow md:mx-auto">
            <div class="flex"> 
            <h1 class="mt-3 ml-5"> Edit Project </h1>
            <a id="go-back" class="cursor-pointer sm:text-big text-bigPhone fixed right-5 mt-1">&times;</a>
            </div>
            <div class="flex sm:h-36 h-24 m-5 mb-10">
                @can('edit', $project)
                    <form method="POST" action="/projects/upload/{{ $project->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="sm:h-36 h-24 aspect-square sm:ml-5 ml-1">
                            <label for="edit-img">
                                <label class="absolute sm:h-36 h-24 aspect-square text-center flex flex-col justify-around pointer-events-none md:text-big text-bigPhone">&#9998;</label>
                                <img id='preview-img' class="sm:h-36 h-24 aspect-square hover:opacity-50" src={{ $project->getImage() }}>
                            </label>
                        </div>
                        <input id="edit-img" class="hidden" name="file" type="file" required>
                        <input name="type" type="hidden" value="project">
                        <input class="button w-min" type="submit" value="Upload project picture">
                    </form>
                @endcan
            </div>
            @include('form.project-edit', ['project'=>$project])
        </div>
    </div>
    @endif
@endsection