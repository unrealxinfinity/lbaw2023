<article class="world" data-id="{{ $world->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $world->id }}"> {{ $world->name }}</a></p>
    <header>
        <h2><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
    </header>
    <a class="button" href="/worlds/{{ $world->id }}/create-project">Create Project</a>
    @include('partials.sidebar', ['thing'=>$world])
    @include('form.search-project', ['world' => $world])
    <ul>
    
        <h2> Ongoing Projects: </h2>
        <div class="row">
        @foreach ($world->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
            <div class="box">
            @include('partials.project', ['project' => $project, 'main' => false, 'tags'=>$project->tags()->orderBy('id')->get()])
            </div>
        @endforeach
        </div>
    </ul>
    <ul>
        <h2> Archived Projects: </h2>
        <div class="row">
        @foreach ($world->projects()->where('status', '=', 'Archived')->orderBy('id')->get() as $project)
            <div class="box">
            @include('partials.project', ['project' => $project, 'main' => false])
            </div>
        @endforeach
        </div>
    </ul>
    @include('form.addmembertoworld', ['world' => $world])
    <section id="comments">
        <h4> Comments: </h4>
        <ul>
            @each('partials.comment', $world->comments()->orderBy('id')->get(), 'comment')
        </ul>
        @include('form.comment', ['route' => 'world-comment', 'id' => $world->id])
    </section>
</article>