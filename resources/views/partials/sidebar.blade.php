<article class="side-bar">
    <h2> Description </h2>
    <p>{{ $thing->description }}</p>
    <h2>Members</h2>
    <ul class="members">
        @foreach($thing->members()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
</article>