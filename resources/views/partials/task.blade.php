<article class="task desktop:w-2/3 desktop:mr-5" data-id = "{{ $task->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a> > <a href="/projects/{{ $task->project->id }}"> {{ $task->project->name }}</a> > <a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></p>
    <header class="mt-5 mb-2 flex justify-between">
        <h1><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h1>
        <h4><label id="sidebar-text" for="show-details" class="desktop:hidden cursor-pointer text-opacity-50 outline outline-1 p-1 tablet:uppercase"> see details </label></h4>
        @can('delete', $task)
            <div class="relative flex justify-end text-left pt-1">
                <input type="checkbox" id="task-more-options" class="sr-only sr-only-focusable peer"/>
                <h1><label for="task-more-options" class="font-bold cursor-pointer sr-only-focusable">&#8942;</label></h1>
                <div class="absolute right-0 px-1 z-10 mr-2 desktop:mt-7 tablet:mt-6 mt-5 min-w-max bg-black outline outline-1 outline-white/20 peer-checked:block hidden divide-y divide-white divide-opacity-25">
                    <form method="POST" class="delete-task" action={{ route('delete-task', ['id' => $task->id]) }}>
                        <fieldset>
                            <legend class="sr-only">Delete Task</legend>
                            @csrf
                            @method('DELETE')
                            <h3><button class="px-3 py-1 w-full" type="submit">Delete Task</button></h3>
                        </fieldset>
                    </form>
                </div>
            </div>
        @endcan
    </header>
    <p>{{ $task->description }}</p>
    <div class="desktop:hidden">
        @if ($errors->any()) <script defer>document.querySelector('#sidebar-text').click();</script> @endif
    </div>
    <section id="comments" class="mt-20">
        <h4> Comments: </h4>
        <ul>
            @foreach ($task->comments()->orderBy('id')->get() as $comment)
                @include('partials.comment', ['comment' => $comment, 'type' => 'task'])
            @endforeach
        </ul>
        @can('edit', $task)
        <span id="make-comment-task"></span>
        @include('form.comment', ['route' => 'task-comment', 'id' => $task->id, 'type' => 'task'])
        @endcan
    </section>
</article>