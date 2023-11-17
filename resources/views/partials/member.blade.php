<article class="member" data-id="{{ $member->id }}">
    @if($main)
    <header class="main">
        <img src= {{$member->picture}} class="main">
        <div>
        <h2>{{ $member->persistentUser->user->username }}</h2>
        <h3>{{ $member->email }}</h3>
        </div>
    </header>
    <h3>{{ $member->description }}
    @else
    <header>
        <img src= {{$member->picture}} class="not-main">
        <h4><a href="/members/{{ $member->id }}">{{ $member->persistentUser->user->username }}</a></h4>
    </header>
    @endif
</article>