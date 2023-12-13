<article class="member" data-id="{{ $member->id }}">
    @if($main)
    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a></p>
    <header class="flex justify-start mobile:h-28 tablet:h-32 desktop:h-40 h-20 tablet:my-5 my-2 ml-1">
        <img src="{{ $member->getProfileImage() }}" class="h-full aspect-square object-cover">
        <div class="flex flex-col tablet:ml-5 mobile:ml-2 ml-1 pt-1">
            <h1>{{ $member->name }}</h1>
            <h2> @ {{ $member->persistentUser->user->username }}</h2>
            @include('partials.tag', ['tags' => $member->tags,'type'=>'member'])
        </div>
    </header>
    <h3 class="mb-5">{{ $member->description }}</h3>
    @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
        @if ($member->persistentUser->type_ == 'Member')
            <a class="button" href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
            <button type="button" id="delete-account" class="link text-red">Delete Account</button>
            <div class="flex mobile:flex-row flex-col justify-around mt-10 child:self-center">
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href = "/myfavorites" >My Favorites</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href = "/myworlds" >My Worlds</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href="/myprojects">My Projects</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href="/mytasks">My Tasks</a></h2>
            <h2 class="text-center desktop:w-40 w-36 p-4 m-1 rounded outline outline-1 outline-white/20 bg-black/50 uppercase"> <a href="/invites">My Invites</a></h2>
        </div>
        @elseif ($member->persistentUser->type_ == 'Blocked')
            @can('appeal', Member::class)
                <a class="button" href="/appeal">Appeal Block</a>
            @else
                <a class="button">Appeal Sent</a>
            @endcan
        @endif
        @can('memberTagCreate', $member)
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
            @include('form.appeal', ['member' => $member])
        </div>
    </div>
    @endif
    @else
    <header class="h-fit flex justify-start">
        <img src="{{$member->getProfileImage()}}" class="h-5 aspect-square mr-3 object-cover">
        @if ($member->persistentUser->type_ == 'Member') <h4 class="self-center"><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
        @elseif ($member->persistentUser->type_ == 'Deleted') <h4 class="self-center">deleted</h4>
        @endif
        @can('request', $member)
            <a class="friend-button justify-self-end" href="/api/request/{{ $member->persistentUser->user->username }}">&#10010;</a>
        @endcan        
    </header>
    @endif
</article>