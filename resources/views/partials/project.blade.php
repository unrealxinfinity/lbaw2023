<article class="project" data-id="{{ $project->id }}">
    @if($main)
        <p><a href="/">Home</a> > <a href="/worlds/{{ $project->world->id }}"> {{ $project->world->name }}</a> > <a href="/projects/{{ $project->id }}">{{ $project->name }}</a></p>
    @endif
    <header>
        <h2><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
    </header>
    @if($main)
    @if (Auth::user()->can('delete', $project))
            <form method="POST" action="{{ route('delete-project', ['id' => $project->id]) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete Project">
            </form>
        @endif
    @include('form.search-task', ['project' => $project])
    <h3>This project belongs to: <a href="/worlds/{{ $project->world->id }}">{{ $project->world->name }}</a></h3>
    <h3>Tags:</h3>
     @include('partials.tag', ['tags' => $tags])
    
    <h3>Tasks:</h3>
    <div class="row">
        @foreach (['BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done'] as $state)
            <div class="column border">
                <h4> {{$state}} </h4>
                <ul class="big-box">
                    @foreach ($project->tasks()->where('status', '=', $state)->orderBy('id')->get() as $task)
                        @include('partials.task', ['task' => $task, 'main' => false])
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    @include('partials.sidebar', ['thing'=>$project])
    @include('form.addmember', ['project' => $project])
    @endif
</article>