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
    <form method="POST" action="/members/upload/{{ $member->id }}" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <input name="file" type="file" required>
        <input name="type" type="hidden" value="profile">
        <input type="submit" value="Upload profile picture">
    </form>
    <h2 class="mb-5">{{ $member->description }}</h2>
    @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
        <a class="button" href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
        <h1> <a href = "/myworlds" >My Worlds</a></h1>
        <h1> <a href="/myprojects">My Projects</a></h1>
        <h1> <a href="/mytasks">My Tasks</a></h1>
    @endif
    @else
    <header class="flex justify-start">
        <img src= {{$member->picture}} class="h-fit aspect-square mx-1">
        <h4><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
    </header>
    @endif
</article>