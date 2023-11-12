<article class="world" data-id="{{ $world->id }}">
    <header>
        <h2><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
    </header>
    <ul>
        @each('partials.member', $world->members()->orderBy('id')->get(), 'member')
    </ul>
</article>