<article class="project" data-id="{{ $project->id }}">
    <header>
        <h2><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
    </header>
    @if($main)
    <h3>This project belongs to: <a href="/worlds/{{ $project->world->id }}">{{ $project->world->name }}</a></h3>
    <h3>Tasks:</h3>
    <ul>
        @each('partials.task', $project->tasks()->orderBy('id')->get(), 'task')
    </ul>
    <ul class="side-bar">
        <h2> Description </h2>
        <article>{{ $project->description }}</article>
        <h2>Members</h2>
        @foreach($project->members()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
        @include('form.addmember', ['project' => $project])
    @endif
</article>