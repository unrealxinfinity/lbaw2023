<article class="project desktop:w-2/3 desktop:mr-5" data-id="{{ $project->id }}">
    <div class="flex justify-between">
        <p><a href="/">Home</a> > <a href="/worlds/{{ $project->world->id }}"> {{ $project->world->name }}</a> > <a href="/projects/{{ $project->id }}">{{ $project->name }}</a></p>
        <h4><label for="show-details" class="desktop:hidden cursor-pointer text-opacity-50 outline outline-1 p-1 tablet:uppercase"> see details </label></h4>
    </div>
    <header class="flex justify-between mobile:h-28 tablet:h-32 desktop:h-40 h-20 tablet:my-5 my-2 ml-1">
        <div class="flex justify-start">
        <img class="h-full aspect-square object-cover" src={{ $project->getImage() }} alt="{{$project->name}} image">
        <div class="flex flex-col tablet:ml-5 mobile:ml-2 ml-1 pt-1">
            <div class="flex">
            <h1>{{ $project->name }}</h1>
            @can('edit', $project)
                <h1><a class="mt-2 tablet:ml-2 ml-1 hover:text-green" href="/projects/{{ $project->id }}/edit">&#9998;</a></h1>
            @endcan
            </div>
            @include('partials.tag', ['tags' => $tags,'type' => 'project'])
        </div>
        </div>
        <div class="relative flex text-left pt-1">
            @can('favorite', $project)
                <form id="favorite">
                    @csrf
                    <input type="hidden" class="id" name="id" value="{{ $project->id }}">
                    <input type="hidden" class="type" name="type" value="projects">
                    <h1><button class="pr-2" type="submit">
                        @if(Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator') && Auth::user()->persistentUser->member->favoriteProject->contains('id', $project->id)) &#9733; 
                        @elseif((Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator'))) &#9734; @endif</button></h1>
                </form>
            @endcan
            @if (Auth::user()->can('delete', $project) || (Auth::user()->persistentUser->member->projects->contains('id', $project->id)))
                <input type="checkbox" id="more-options" class="hidden peer"/>
                <h1><label for="more-options" class="font-bold cursor-pointer">&#8942;</label></h1>
                <div class="absolute right-0 px-1 z-10 mr-2 desktop:mt-7 tablet:mt-6 mt-5 min-w-max bg-black outline outline-1 outline-white/20 peer-checked:block hidden divide-y divide-white divide-opacity-25">
                    @can('delete', $project)
                    <form method="POST" class= "delete-project" action="{{ route('delete-project', ['id' => $project->id]) }}">
                        @csrf
                        @method('DELETE')
                        <h3><button class="px-3 py-1 w-full" type="submit">Delete Project</button></h3>
                    </form>
                    @endcan
                    @if (Auth::user()->can('edit', $project) && $project->status == 'Active')
                    <form class = "archive-project" method="POST" action="{{ route('archive-project', ['id' => $project->id]) }}">
                        @csrf
                        @method('POST')
                        <h3><button class="px-3 py-1 w-full" type="submit">Archive Project</button></h3>
                    </form>
                    @endif
                    @if(Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator') && Auth::user()->persistentUser->member->projects->contains('id', $project->id))
                        <form method="POST" class="leave-project" action={{ route('leave-project', ['id' => $project->id, 'username' => Auth::user()->username]) }}>
                            @CSRF
                            @method('DELETE')
                            <h3><button class="px-3 py-1 w-full" type="submit">Leave Project</button></h3>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </header>
    @include('form.search-task', ['project' => $project])
    <h2 class="mt-10"> TASKS </h2>
    <div class="panel w-full">
        @foreach (['BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done'] as $state)
            <div class="big-box flex flex-col justify-start m-1 px-1 py-2 h-128 bg-black bg-opacity-50 outline outline-1 outline-white/20 rounded min-w-[12rem] w-48">
                <h3 class="text-center inline-block mb-3"> {{$state}} </h3>
                @foreach ($project->tasks()->where('status', '=', $state)->get() as $task)
                <article class="task bg-white child:text-black p-2 m-1 rounded" @can('edit', $task) draggable="true" id="task-{{ $task->id }}" @endcan>
                    <h2 class="text-green font-semibold"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
                    <p>{{ $task->description }}</p>
                </article>
                @endforeach
            </div>
        @endforeach
    </div>
    @can('projectTagCreate', $project)
    <section id="create-tag">
        @include('form.tag-create',['project'=> $project,'type' => 'project'])
    </section>
    @endcan
    @can('addMember', $project)
    <section id="add-member">
        @include('form.addmember', ['project' => $project])
    </section>
    @endcan
    @can('createTask', $project)
    <section id="create-task">
        @include('form.task-create', ['project' => $project])
    </section>
    @endcan
    
</article>