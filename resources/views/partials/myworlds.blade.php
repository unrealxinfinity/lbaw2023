<article class="myworld bg-grey rounded m-5" data-id="{{ $world->id }}">
    <div class="flex">
        <img src={{$world->getImage()}} class="h-16 aspect-square mt-5 ml-5 ">
        <div class="flex flex-col">
            <h1 class="text-white"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h1>
            <h2 class="ml-3 mb-5"> {{ $world->description }} </h2>
        </div>
    </div>
</article>