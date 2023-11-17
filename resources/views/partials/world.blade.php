<article class="world" data-id="{{ $world->id }}">
    <header>
        <h2><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
    </header>
    <ul class="side-bar">
        <h2> Description </h2>
        <article>{{ $world->description }}</article>
        <h2> Members </h2>
        @foreach($world->members()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
    <ul>
        <h2> Projects: </h2>
        <div>
        @foreach ($world->projects()->orderBy('id')->get() as $project)
            @include('partials.project', ['project' => $project, 'main' => false])
        @endforeach
        </div>
    </ul>
</article>