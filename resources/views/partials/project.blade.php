<article class="project md:w-3/4 peer-checked:fixed" data-id="{{ $project->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $project->world->id }}"> {{ $project->world->name }}</a> > <a href="/projects/{{ $project->id }}">{{ $project->name }}</a></p>
    <header class="flex justify-start sm:h-40 h-24 m-5">
        <img class="pfp" src="https://source.unsplash.com/random/300x200">
        <div class="flex flex-col ml-5 pt-1">
            <h1><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h1>
            @include('partials.tag', ['tags' => $tags])
            <label for="show-details" class="md:hidden cursor-pointer text-mediumPhone sm:m-3 m-2 w-fit mt-5 underline text-grey"> see details </label>
        </div>
    </header>
    @if (Auth::user()->can('delete', $project))
        <form method="POST" action="{{ route('delete-project', ['id' => $project->id]) }}">
            @csrf
            @method('DELETE')
            <input class="button" type="submit" value="Delete Project">
        </form>
    @endif
    @include('form.search-task', ['project' => $project])
    <h2 class="mt-10"> TASKS </h2>
    <div class="panel w-full">
        @foreach (['BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done'] as $state)
            <div class="flex flex-col justify-start mx-1 px-1 py-2 h-128 bg-grey rounded">
                <h2 class="text-center inline-block"> {{$state}} </h2>
                <ul class="min-w-[12rem] w-48">
                    @foreach ($project->tasks()->where('status', '=', $state)->orderBy('id')->get() as $task)
                    <div class="bg-white text-black p-1 m-1 rounded">
                        <h2><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
                        <p>{{ $task->description }}</p>
                    </div>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    @if (Auth::user()->can('addMember', $project))
    <section id="add-member">
        @include('form.addmember', ['project' => $project])
    </section>
    @endif
    @if (Auth::user()->persistentUser->member->projects->contains('id', $project->id))
    <section id="create-task">
        @include('partials.task-create', ['project' => $project])
    </section>
    <section id="create-tag">
        @include('form.tag-create',['project'=> $project])
    </section>
    @endif
</article>