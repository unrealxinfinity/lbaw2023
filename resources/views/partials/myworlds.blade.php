<article class="myworld flex justify-between h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $world->id }}">
    <div class="flex">
        <img src={{$world->getImage()}} alt="{{$world->name}} image" class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="break-words"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
            <h4 class="break-words"> {{ $world->description }} </h4>
        </div>
    </div>
    @canany(['delete', 'leave'], $world)
        <input type="checkbox" id="more-options-{{$world->id}}" class="hidden peer"/>
        <h1 id="h1-{{$world->id}}"><label for="more-options-{{$world->id}}" class="font-bold cursor-pointer">&#8942;</label></h1>
        <div class="absolute right-0 px-1 z-10 mr-6 tablet:mr-14 desktop:mt-7 tablet:mt-6 mt-5 min-w-max bg-black outline outline-1 outline-white/20 peer-checked:block hidden divide-y divide-white divide-opacity-25">
            @can('delete', $world)
                @include('form.delete-world-in-list', ['world' => $world])
            @endcan
            @can('leave', $world)
                <form class="leave-world-list">
                    <fieldset>
                        <legend class="sr-only">Leave World</legend>
                        @CSRF
                        <input type="hidden" class="id" name="id" value={{$world->id}}>
                        <input type="hidden" class="username" name="username" value={{Auth::user()->username}}>
                        <h3><button class="px-3 py-1 w-full" type="submit">Leave World</button></h3>
                    </fieldset>
                </form>
            @endcan
        </div>
    @endcanany
</article>