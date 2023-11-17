<article class="world" data-id="{{ $world->id }}">
    <header>
        <h2><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
    </header>
    @include('partials.sidebar', ['thing'=>$world])
    <ul>
        <h2> Ongoing Projects: </h2>
        <div class="row">
        @foreach ($world->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
            <div class="box">
            @include('partials.project', ['project' => $project, 'main' => false])
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
</article>