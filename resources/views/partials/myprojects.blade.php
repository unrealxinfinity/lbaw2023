<article class="myproject bg-grey rounded m-5" data-id="{{ $project->id }}">
    <div class="flex">
        <img src={{$project->getImage()}} class="h-16 aspect-square mt-5 ml-5 ">
        <div class="flex flex-col">
            <h1 class="text-white"><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h1>
            <h2 class="ml-3 mb-5"> {{ $project->description }} </h2>
        </div>
    </div>
</article>