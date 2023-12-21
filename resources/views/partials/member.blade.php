<article class="member" data-id="{{ $member->id }}">
    @if($main)
        @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
            @if ($member->persistentUser->type_ == 'Member')
                <a href="#profile-edit-profile" class="sr-only sr-only-focusable">Edit Profile</a>
                <a href="#delete-account" class="sr-only sr-only-focusable">Delete Account</a>
                <a href="#profile-my-favorites" class="sr-only sr-only-focusable">My Favorites</a>
                <a href="#profile-my-worlds" class="sr-only sr-only-focusable">My Worlds</a>
                <a href="#profile-my-projects" class="sr-only sr-only-focusable">My Projects</a>
                <a href="#profile-my-tasks" class="sr-only sr-only-focusable">My Tasks</a>
                <a href="#profile-my-invites" class="sr-only sr-only-focusable">My Invites</a>
                @can('memberTagCreate', $member)
                    <a href="#profile-create-tag" class="sr-only sr-only-focusable">Create Tag</a>
                @endcan
            @endif
        @endif
        @can('appeal', $member)
            <a href="#profile-send-appeal" class="sr-only sr-only-focusable">Appeal Block</a>
        @endcan

    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a></p>
    <header class="flex justify-start mobile:h-28 tablet:h-32 desktop:h-40 h-20 tablet:my-5 my-2 ml-1">
        <img src="{{ $member->getProfileImage() }}" alt="{{$member->persistentUser->user->username}} profile picture" class="h-full aspect-square object-cover">
        <div class="flex flex-col tablet:ml-5 mobile:ml-2 ml-1 pt-1">
            <h1>{{ $member->name }}</h1>
            <h2> @ {{ $member->persistentUser->user->username }}</h2>
            @include('partials.tag', ['tags' => $member->tags,'type'=>'member'])
        </div>
    </header>
    <h3 class="mb-5">{{ $member->description }}</h3>
    @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
        @if ($member->persistentUser->type_ == 'Member')
            <a class="button" id="profile-edit-profile" href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
            <button type="button" id="delete-account" class="link text-red">Delete Account</button>
            <div class="flex mobile:flex-row flex-col justify-around mt-10 child:self-center">
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a id="profile-my-favorites" href = "/myfavorites" >My Favorites</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a id="profile-my-worlds" href = "/myworlds" >My Worlds</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a id="profile-my-projects" href="/myprojects">My Projects</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a id="profile-my-tasks" href="/mytasks">My Tasks</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a id="profile-my-invites" href="/invites">My Invites</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a id="profile-my-friends" href="/myfriends">My Friends</a></h2>
        </div>
        @elseif ($member->persistentUser->type_ == 'Blocked')
        <h2 class="decoration-green underline underline-offset-4 decoration-2"> YOU HAVE BEEN BLOCKED </h2>
        <p class="my-4">Reason for block: {{ $member->persistentUser->block_reason }}</p>
            @can('appeal', $member)
                <a id="profile-send-appeal" class="button" href="/appeal">Appeal Block</a>
            @else
                <a class="button" href="/appeal">View Appeal</a>
            @endcan
        @endif
        @can('memberTagCreate', $member)
            <span id="profile-create-tag"></span>
            @include('form.tag-create', ['type' => 'member'])
        @endcan
    @endif
    @if ($appeal)
    <div id="appeal-box" class="fixed z-10 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-center">
        <div class="bg-black tablet:w-3/4 tablet:h-4/5 h-full rounded drop-shadow tablet:mx-auto">
            <div class="flex"> 
            <h1 class="mt-3 ml-5"> Appeal Block </h1>
            <a id="go-back" class="cursor-pointer sm:text-big text-bigPhone fixed right-5 mt-1">&times;</a>
            </div>
            @if (isset($member->appeal))
                @include('partials.appeal-readonly', ['member' => $member])
            @else    
                @include('form.appeal', ['member' => $member])
            @endif    
        </div>
    </div>
    @endif
    @else
    <header class="h-fit flex justify-start">
        <img src="{{$member->getProfileImage()}}" alt="{{$member->persistentUser->user->username ?? ''}} profile picture" class="h-5 aspect-square mr-3 object-cover">
        @if ($member->persistentUser->type_ == 'Member' || $member->persistentUser->type_ == 'Blocked') <h4 class="self-center"><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
        @elseif ($member->persistentUser->type_ == 'Deleted') <h4 class="self-center">deleted</h4>
        @endif
        @can('request', $member)
            <a class="friend-button justify-self-end" href="/api/request/{{ $member->persistentUser->user->username }}">&#10010;</a>
        @endcan        
    </header>
    @endif
</article>