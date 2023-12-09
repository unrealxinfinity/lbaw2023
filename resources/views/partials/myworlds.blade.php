<article class="myworld flex justify-between h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $world->id }}">
    <div class="flex">
        <img src={{$world->getImage()}} class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="break-words"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
            <h4 class="break-words"> {{ $world->description }} </h4>
        </div>
    </div>
    @canany(['delete', 'leave'], $world)
        <input type="checkbox" id="more-options-{{$world->id}}" class="hidden peer"/>
        <label for="more-options-{{$world->id}}" class="text-start font-bold md:text-big text-bigPhone h-fit my-3 sm:mr-5 cursor-pointer">&#8942;</label>
        <div class="absolute right-0 z-10 w-40 sm:mr-5 px-2 rounded bg-grey peer-checked:block hidden divide-y divide-white divide-opacity-25">
            @can('delete', $world)
                @include('form.delete-world-in-list', ['world' => $world])
            @endcan
            @can('leave', $world)
                <form class="leave-world-list">
                    @CSRF
                    <input type="hidden" class="id" name="id" value={{$world->id}}>
                    <input type="hidden" class="username" name="username" value={{Auth::user()->username}}>
                    <button class="px-3 py-1 w-full md:text-medium text-mediumPhone" type="submit">Leave World</button>
                </form>
            @endcan
        </div>
    @endcanany
</article>