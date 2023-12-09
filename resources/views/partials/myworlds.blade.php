<article class="myworld flex h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $world->id }}">
        <img src={{$world->getImage()}} class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="break-words"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
            <h4 class="break-words"> {{ $world->description }} </h4>
        </div>
</article>