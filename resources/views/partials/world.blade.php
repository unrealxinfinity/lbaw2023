<article class="world" data-id="{{ $world->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $world->id }}"> {{ $world->name }}</a></p>
    <header>
        <h1><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h1>
    </header>
    <a class="button" href="/worlds/{{ $world->id }}/create-project">Create Project</a>
    <section id="search-project">@include('form.search-project', ['world' => $world])</section>
    <section id="projects">
        <h2> Ongoing Projects: </h2>
        <ul class="row">
            @foreach ($world->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
                <nav class="box">
                    <h3><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h3>
                </nav>
            @endforeach
        </ul>
        <h2> Archived Projects: </h2>
        <ul class="row">
            @foreach ($world->projects()->where('status', '=', 'Archived')->orderBy('id')->get() as $project)
                <nav class="box">
                    <h3><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h3>
                </nav>
            @endforeach
        </ul>
    </section>
    @include('form.addmembertoworld', ['world' => $world])
    <section id="comments">
        <h4> Comments: </h4>
        <ul>
            @each('partials.comment', $world->comments()->orderBy('id')->get(), 'comment')
        </ul>
        @include('form.comment', ['route' => 'world-comment', 'id' => $world->id])
    </section>
</article>
