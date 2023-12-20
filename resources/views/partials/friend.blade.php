<article class="myworld flex justify-between h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $friend->id }}">
    <div class="flex">
        <img src={{$friend->getProfileImage()}} alt="{{$friend->persistentUser->user->username}} image" class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="break-words"><a href="/members/{{ $friend->id }}">{{ $friend->persistentUser->user->username }}</a></h2>
            <h4 class="break-words"> {{ $friend->description }} </h4>
        </div>
    </div>
    <div class="absolute right-0 px-1 z-10 mr-6 tablet:mr-14 desktop:mt-7 tablet:mt-6 mt-5 min-w-max bg-black outline outline-1 outline-white/20 peer-checked:block hidden divide-y divide-white divide-opacity-25">
        <form method="POST" action={{ route('api-remove-friend', ['id' => $friend->id])}}>
            <fieldset>
                <legend class="sr-only">Remove Friend</legend>
                @csrf
                <input type="hidden" class="id" name="id" value={{$friend->id}}>
                <h3><button class="px-3 py-1 w-full" type="submit">Remove Friend</button></h3>
            </fieldset>
        </form>
    </div>
</article>