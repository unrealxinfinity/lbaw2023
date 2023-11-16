<article class="project" data-id="{{ $project->id }}">
    <header>
        <h2><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
        <p>{{ $project->description }}</p>
    </header>
    <h3>This project belongs to: <a href="/worlds/{{ $project->world->id }}">{{ $project->world->name }}</a></h3>
    <h3>Tags:</h3>
    <ul>
        @each('partials.project-tag', $project->projecttags()->orderBy('id')->get(), 'projecttag')
    </ul>
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