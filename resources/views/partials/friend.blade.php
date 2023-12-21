<article class="flex justify-between h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $friend->id }}">
    <img src={{$friend->getProfileImage()}} alt="{{$friend->persistentUser->user->username}} image" class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
    <div class="flex flex-col self-center ml-3 w-11/12">
        <h2 class="break-words"><a href="/members/{{ $friend->persistentUser->user->username }}">{{ $friend->persistentUser->user->username }}</a></h2>
        <h3 class="break-words"> @ {{ $friend->persistentUser->user->username }}</h3>
        <h4 class="pt-2 break-words"> {{ $friend->description }} </h4>
    </div>
    <div class="justify-self-end self-center h-fit">
        <form method="POST" class="remove-friend-form" action={{ route('api-remove-friend', ['id' => $friend->id])}}>
            <fieldset>
                <legend class="sr-only">Remove Friend</legend>
                @csrf
                @method('DELETE')
                <input type="hidden" class="id" name="id" value={{$friend->id}}>
                <h1><button class="px-3 py-1 text-red" type="submit" title="Remove Friend">&times;</button></h1>
            </fieldset>
        </form>
    </div>
</article>