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
        <a href="/members/{{ $member->persistentUser->user->username }}/edit">Edit Profile</a>
    @endif
    @else
    <header class="row">
        <img src= {{$member->picture}} class="small">
        <h4><a href="/members/{{ $member->persistentUser->user->username }}">{{ $member->persistentUser->user->username }}</a></h4>
    </header>
    @endif
</article>