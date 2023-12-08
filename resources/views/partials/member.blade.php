<article class="member" data-id="{{ $member->id }}">
    @if($main)
    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a></p>
    <header class="flex justify-start mobile:h-28 tablet:h-32 desktop:h-40 h-20 tablet:my-5 my-2 ml-1">
        <img src="{{ $member->getProfileImage() }}" class="h-full aspect-square">
        <div class="flex flex-col tablet:ml-5 mobile:ml-2 ml-1 pt-1">
            <h1>{{ $member->name }}</h1>
            <h2> @ {{ $member->persistentUser->user->username }}</h2>
            <div class="flex flex-wrap overflow-hidden mt-2"> <p class="tag"> placeholder </p> <p class="tag"> for tags </p>
        </div>
    </header>
    <h3 class="mb-5">{{ $member->description }}</h3>
    @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
        @if ($member->persistentUser->type_ == 'Member')
            <a class="button" href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
        @elseif ($member->persistentUser->type_ == 'Blocked')
            <a class="button">Appeal Block</a>
        @endif
        <button type="button" id="delete-account" class="link text-red">Delete Account</button>
        <div class="flex mobile:flex-row flex-col justify-around mt-10 child:self-center">
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href = "/myfavorites" >My Favorites</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href = "/myworlds" >My Worlds</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href="/myprojects">My Projects</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href="/mytasks">My Tasks</a></h2>
        </div>
    @endif
    @else
    <header class="h-fit flex justify-start">
        <img src="{{$member->getProfileImage()}}" class="h-5 aspect-square mr-3">
        @if ($member->persistentUser->type_ == 'Member') <h4 class="self-center"><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
        @elseif ($member->persistentUser->type_ == 'Deleted') <h4 class="self-center">deleted</h4>
        @endif
    </header>
    @endif
</article>