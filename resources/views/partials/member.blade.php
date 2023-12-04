<article class="member" data-id="{{ $member->id }}">
    @if($main)
    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a></p>
    <header class="flex justify-start sm:h-40 h-24 m-5">
        <img src="{{ $member->getProfileImage() }}" class="h-full aspect-square">
        <div class="flex flex-col ml-5 pt-1">
        <h1>{{ $member->name }}</h1>
        <h2 class="pl-3 mb-5"> @ {{ $member->persistentUser->user->username }}</h2>
        <div class="flex"> <p class="tag"> placeholder </p> <p class="tag"> for tags </p>
        </div>
        </div>
    </header>
    <h2 class="mb-5">{{ $member->description }}</h2>
    @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
        @if ($member->persistentUser->type_ == 'Member')
            <a class="button" href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
        @elseif ($member->persistentUser->type_ == 'Blocked')
        <a class="button">Appeal Block</a>
        @endif
        <button type="button" id="delete-account" class="button">Delete Account</button>
        <h1> <a href = "/myworlds" >My Worlds</a></h1>
        <h1> <a href="/myprojects">My Projects</a></h1>
        <h1> <a href="/mytasks">My Tasks</a></h1>
    @endif
    @else
    <header class="h-10 flex justify-start">
        <img src="{{$member->getProfileImage()}}" class="h-5 aspect-square mx-1">
        @if ($member->persistentUser->type_ == 'Member') <h4 class="pt-0.5 md:pt-0"><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
        @elseif ($member->persistentUser->type_ == 'Deleted') <h4 class="pt-0.5 md:pt-0">deleted</h4>
        @endif
    </header>
    @endif
</article>