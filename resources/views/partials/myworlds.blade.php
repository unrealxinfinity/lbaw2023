<article class="myworld bg-grey rounded m-5" data-id="{{ $world->id }}">
    <div class="flex">
        <img src={{$world->getImage()}} class="h-16 aspect-square mt-5 ml-5 ">
        <div class="flex flex-col">
            <h1 class="text-white"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h1>
            <h2 class="ml-3 mb-5"> {{ $world->description }} </h2>
        </div>
        @if(Auth::check() && Auth::user()->can('leave', $world) || Auth::user()->can('delete', $world))
            <input type="checkbox" id="more-options-{{$world->id}}" class="hidden peer"/>
            <label for="more-options-{{$world->id}}" class="text-start font-bold md:text-big text-bigPhone h-fit my-3 sm:mr-5 cursor-pointer">&#8942;</label>
            <div class="absolute right-0 z-10 w-40 sm:mr-5 px-2 rounded bg-grey peer-checked:block hidden divide-y divide-white divide-opacity-25">
                @if(Auth::check() && Auth::user()->can('delete', $world))
                @include('form.delete-world', ['world' => $world])
                @endif
                @if(Auth::check() && Auth::user()->can('leave', $world))
                    <form method="POST" action={{ route('leave-world', ['id' => $world->id, 'username' => Auth::user()->username]) }}>
                        @CSRF
                        @method('DELETE')
                        <button class="px-3 py-1 w-full md:text-medium text-mediumPhone" type="submit">Leave World</button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</article>