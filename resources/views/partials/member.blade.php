<article class="member" data-id="{{ $member->id }}">
    @if($main)
    <p><a href="/">Home</a> > <a href="/members/{{$member->persistentUser->user->username}}">{{$member->persistentUser->user->username}}</a></p>
    <header class="row">
        <img src= {{$member->picture}} class="big">
        <div class="column">
        <h2>{{ $member->name }}</h2>
        <h3> @ {{ $member->persistentUser->user->username }}</h3>
        </div>
    </header>
    <h4>{{ $member->description }}</h4>
    @if (Auth::check() && Auth::user()->id == $member->persistentUser->user->id)
        <a class="button" href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
        <h3> <a href = "/myworlds" >My Worlds</a></h3>
        <h3> <a href="/myprojects">My Projects</a></h3>
        <h3> <a href="/mytasks">My Tasks</a></h3>
    @endif
    @else
    <header class="flex justify-start">
        <img src= {{$member->picture}} class="h-fit aspect-square mx-1">
        <h4><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
    </header>
    @endif
</article>