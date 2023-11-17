<article class="project" data-id="{{ $project->id }}">
    <header>
        <h2><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
        <p>{{ $project->description }}</p>
        @if ((Auth::user()->persistentUser->member->projects->where('id', $project->id)[0]->pivot->permission_level) == 'Project Leader')
            <form method="POST" action="{{ route('delete-project', ['id' => $project->id]) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete Project">
            </form>
        @endif
    </header>
    <h3>This project belongs to: <a href="/worlds/{{ $project->world->id }}">{{ $project->world->name }}</a></h3>
    <h3>Tags:</h3>
    @include('partials.tag', ['tags' => $tags])
    <h3>Tasks:</h3>
    <ul>
        @each('partials.task', $project->tasks()->orderBy('id')->get(), 'task')
    </ul>
    <h3>Project Members:</h3>
    <ul class="members">
        @each('partials.member', $project->members()->orderBy('id')->get(), 'member')
    </ul>
    @if($main)
        @include('form.addmember', ['project' => $project])
    @endif
</article>