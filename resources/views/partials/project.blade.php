<article class="project md:w-3/4 peer-checked:fixed" data-id="{{ $project->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $project->world->id }}"> {{ $project->world->name }}</a> > <a href="/projects/{{ $project->id }}">{{ $project->name }}</a></p>
    <header class="flex justify-between sm:h-40 h-24 m-5">
        <div class="flex justify-start">
        <img class="h-full aspect-square " src={{ $project->getImage() }}>
        @can('edit', $project)
            <form method="POST" action="/projects/upload/{{ $project->id }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <input class="text-white" name="file" type="file" required>
                <input name="type" type="hidden" value="project">
                <input class="button w-min" type="submit" value="Upload project picture">
            </form>
        @endcan
        <div class="flex flex-col ml-5 pt-1">
            <h1>{{ $project->name }}</h1>
            @if (Auth::user()->can('edit', $project))
                <a class="mt-2 ml-1 text-bigPhone md:text-big hover:text-green" href="/projects/{{ $project->id }}/edit">&#9998;</a>
            @endif
            @include('partials.tag', ['tags' => $tags])
            <label for="show-details" class="md:hidden cursor-pointer text-mediumPhone sm:m-3 m-2 w-fit mt-5 underline text-grey"> see details </label>
        </div>
        </div>
        @if (Auth::user()->can('delete', $project) || (Auth::user()->persistentUser->member->projects->contains('id', $project->id)))
        <div class="relative inline-block text-left">
            <input type="checkbox" id="more-options" class="hidden peer"/>
            <label for="more-options" class="text-start font-bold md:text-big text-bigPhone h-fit my-3 sm:mr-5 cursor-pointer">&#8942;</label>
            <div class="absolute right-0 z-10 w-40 sm:mr-5 px-2 rounded bg-grey peer-checked:block hidden divide-y divide-white divide-opacity-25">
                @if (Auth::user()->can('delete', $project))
                <form method="POST" action="{{ route('delete-project', ['id' => $project->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 w-full" type="submit">Delete Project</button>
                </form>
                @endif
                @if (Auth::user()->can('edit', $project) && $project->status == 'Active')
                <form class = "archive-project" method="POST" action="{{ route('archive-project', ['id' => $project->id]) }}">
                    @csrf
                    @method('POST')
                    <button class="px-3 py-1 w-full" type="submit">Archive Project</button>
                </form>
                @endif
                @if(Auth::check() && Auth::user()->persistentUser->member->projects->contains('id', $project->id))
                    <form method="POST" action={{ route('leave-project', ['id' => $project->id, 'username' => Auth::user()->username]) }}>
                        @CSRF
                        @method('DELETE')
                        <button class="px-3 py-1 w-full" type="submit">Leave Project</button>
                    </form>
                @endif
            </div>
        </div>
        @endif
    </header>
    @include('form.search-task', ['project' => $project])
    <h2 class="mt-10"> TASKS </h2>
    <div class="panel w-full">
        @foreach (['BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done'] as $state)
            <div class="big-box flex flex-col justify-start mx-1 px-1 py-2 h-128 bg-grey rounded min-w-[12rem] w-48">
                <h2 class="text-center inline-block"> {{$state}} </h2>
                @foreach ($project->tasks()->where('status', '=', $state)->get() as $task)
                <article class="task bg-white text-black p-2 m-1 rounded" @if (Auth::user()->can('edit', $task)) draggable="true" id="task-{{ $task->id }}" @endif>
                    <h2 class="text-green font-semibold"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
                    <p>{{ $task->description }}</p>
                </article>
                @endforeach
            </div>
        @endforeach
    </div>
    @if (Auth::user()->can('addMember', $project))
    <section id="add-member">
        @include('form.addmember', ['project' => $project])
    </section>
    @endif
    @if (Auth::user()->can('createTask', $project))
    <section id="create-task">
        @include('form.task-create', ['project' => $project])
    </section>
    @endif
    @if (Auth::user()->can('projectTagCreate', $project))
    <section id="create-tag">
        @include('form.tag-create',['project'=> $project])
    </section>
    @endif
</article>