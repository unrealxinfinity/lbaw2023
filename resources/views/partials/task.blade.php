<article class="task" data-id = "{{ $task->id }}" draggable="true">
    @if($main)
        <p><a href="/">Home</a> > <a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a> > <a href="/projects/{{ $task->project->id }}"> {{ $task->project->name }}</a> > <a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></p>
    @endif
    <header>
        @if($main)<h1><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h1>
        @else<h3><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h3>
        @endif
    </header>
    <p>{{ $task->description }}</p>
    @if($main)
    <h3>This task belongs to: <a href="/projects/{{ $task->project->id }}">{{ $task->project->name }}</a></h3>
    <section id="comments">
        <h4> Comments: </h4>
        <ul>
            @each('partials.comment', $task->comments()->orderBy('id')->get(), 'comment')
        </ul>
        @if (Auth::user()->can('edit', $task))
        @include('form.comment', ['route' => 'task-comment', 'id' => $task->id])
        @endif
    </section>
    @endif
</article>