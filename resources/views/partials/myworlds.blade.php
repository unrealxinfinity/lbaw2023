<article class="myworld bg-grey rounded m-5" data-id="{{ $world->id }}">
    <div class="flex justify-between">
        <div class="flex m-3">
            <img src={{$world->getImage()}} class="h-16 aspect-square mr-3">
            <div class="self-center">
                <h1 class="text-white"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h1>
                <h2 class=""> {{ $world->description }} </h2>
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
    </div>
</article>