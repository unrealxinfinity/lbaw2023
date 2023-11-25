<article class="homepage" data-id="{{ $member->id }}">
        @if(count($tasks) > 0)
            @if ($main) <h1> MY ASSIGNED TASKS </h1>
            @else <h2> Assigned Tasks </h2>
            @endif
            <div class="panel">
            @foreach($tasks as $task)
            <div class="container"> 
                <div class="h-1/2 md:text-medium text-mediumPhone overflow-hidden px-5 flex flex-col justify-center">
                    <h2><a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a>
                     > 
                    <a href="/projects/{{ $task->project->id }}">{{ $task->project->name }}</a></h2>
                </div>
                <div class="container-title"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></div>
                <div class="container-desc"><h4>{{ $task->description }}</h4></div>
            </div>
            @endforeach
            </div>
        @endif
        @if(count($projects) > 0)
            @if ($main) <h1> MY CURRENT PROJECTS </h1>
            @else <h2> My Projects </h2>
            @endif
            <div class="panel">
            @foreach($projects as $project)
            <div class="container">
                <img class="h-1/2 overflow-hidden rounded-t-md" src="https://source.unsplash.com/random/300x200">
                <div class="container-title"><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></div>
                <div class="container-desc"><h4>{{ $project->description }}</h4></div>
            </div>
            @endforeach
            </div>
        @endif
        @if(count($worlds) > 0)
            @if ($main) <h1> MY CURRENT WORLDS <a class="round-button" href="/create-world">+</a></h1> 
            @else <h2> Worlds </h2>
            @endif
            <div class="panel">
            @foreach($worlds as $world)
            <div class="container">
                <img class="h-1/2 overflow-hidden rounded-t-md" src="https://source.unsplash.com/random/300x200">
                <div class="container-title"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></div>
                <div class="container-desc"><h4>{{ $world->description }}</h4></div>
            </div>
            @endforeach
        @endif
        </div>
</article>
