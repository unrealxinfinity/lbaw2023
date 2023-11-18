<article class="member" data-id="{{ $member->id }}">
    @if($main)
    <header class="row">
        <img src= {{$member->picture}} class="big">
        <div class="column">
        <h2>{{ $member->name }}</h2>
        <h3> @ {{ $member->persistentUser->user->username }}</h3>
        </div>
    </header>
    <h4>{{ $member->description }}</h4>
    <a href="/members/{{ $member->id }}/edit">Edit Profile</a>
    @else
    <header class="row">
        <img src= {{$member->picture}} class="small">
        <h4><a href="/members/{{ $member->id }}">{{ $member->persistentUser->user->username }}</a></h4>
    </header>
    @endif
</article>