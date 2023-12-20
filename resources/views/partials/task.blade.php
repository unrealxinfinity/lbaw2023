<article class="task desktop:w-2/3 desktop:mr-5" data-id = "{{ $task->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a> > <a href="/projects/{{ $task->project->id }}"> {{ $task->project->name }}</a> > <a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></p>
    <header class="mt-5 mb-2 flex justify-between">
        <h1><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h1>
        <h4><label id="sidebar-text" for="show-details" class="desktop:hidden cursor-pointer text-opacity-50 outline outline-1 p-1 tablet:uppercase"> see details </label></h4>
    </header>
    <p>{{ $task->description }}</p>
    <div class="desktop:hidden">
        @if ($errors->any()) <script defer>document.querySelector('#sidebar-text').click();</script> @endif
    </div>
    <section id="comments" class="mt-20">
        <h4> Comments: </h4>
        <ul>
            @foreach ($task->comments()->orderBy('id')->get() as $comment)
                <li>@include('partials.comment', ['comment' => $comment, 'type' => 'task']) </li>
            @endforeach
        </ul>
        @can('edit', $task)
        <span id="make-comment-task"></span>
        @include('form.comment', ['route' => 'task-comment', 'id' => $task->id, 'type' => 'task'])
        @endcan
    </section>
</article>