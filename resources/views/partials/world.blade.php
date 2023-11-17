<article class="world" data-id="{{ $world->id }}">
    <header>
        <h2><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
    </header>
    <ul>
        @each('partials.member', $world->members()->orderBy('id')->get(), 'member')
    </ul>
    <ul>
        Projects:
        @foreach ($world->projects()->orderBy('id')->get() as $project)
            @include('partials.project', ['project' => $project, 'main' => false])
        @endforeach
    </ul>
    @include('form.addmembertoworld', ['world' => $world])
</article>