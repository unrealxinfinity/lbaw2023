<article class="member" data-id="{{ $member->id }}">
    <header>
        <h2><a href="/members/{{ $member->id }}">{{ $member->persistentUser->user->username }}</a></h2>
        <h3>{{ $member->email }}</h3>
    </header>
    {{ $member->description }}
</article>