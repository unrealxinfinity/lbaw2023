<ul class="side-bar">
        <h2> Description </h2>
        <article>{{ $thing->description }}</article>
        <h2>Members</h2>
        @foreach($thing->members()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>