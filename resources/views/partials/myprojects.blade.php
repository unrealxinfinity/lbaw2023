<article class="myproject flex h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $project->id }}">
        <img src={{$project->getImage()}} class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="break-words"><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
            <h4 class="break-words"> {{ $project->description }} </h4>
        </div>
</article>