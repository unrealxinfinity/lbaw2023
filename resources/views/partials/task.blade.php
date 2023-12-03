<article class="task md:w-1/2 peer-checked:fixed" data-id = "{{ $task->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a> > <a href="/projects/{{ $task->project->id }}"> {{ $task->project->name }}</a> > <a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></p>
    <header>
        <h1><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h1>
    </header>
    <p>{{ $task->description }}</p>
    <label id="sidebar-text" for="show-details" class="md:hidden cursor-pointer text-mediumPhone sm:m-3 m-2 w-fit mt-5 underline text-grey"> see details </label>
    @if ($errors->any()) <script defer>document.querySelector('#sidebar-text').click();</script> @endif
    <section id="comments" class="mt-20">
        <h4> Comments: </h4>
        <ul>
            @foreach ($task->comments()->orderBy('id')->get() as $comment)
                @include('partials.comment', ['comment' => $comment, 'type' => 'task'])
            @endforeach
        </ul>
        @if (Auth::user()->can('edit', $task))
        @include('form.comment', ['route' => 'task-comment', 'id' => $task->id, 'type' => 'task'])
        @endif
    </section>
</article>