<article class="homepage" data-id="{{ $member->id }}">
        @if(count($tasks) > 0)
            @if ($main) <h2> My Assigned Tasks </h2>
            @else <h2> Assigned Tasks </h2>
            @endif
            <div class="panel">
            @foreach($tasks as $task)
            <div class="container"> 
                <h3 class="container-title"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h3>
                <div class="container-desc"><h4 class="container-desc">{{ $task->description }}</h4></div>
            </div>
            @endforeach
            </div>
        @endif
        @if(count($projects) > 0)
            @if ($main) <h2> My Current Projects </h2>
            @else <h2> My Projects </h2>
            @endif
            <div class="panel">
            @foreach($projects as $project)
            <div class="container">
                <img class="max-h-20 min-h-5 h-auto overflow-hidden rounded-t-md" src="https://source.unsplash.com/random/300x200">
                <h3 class="container-title"><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h3>
                <div class="container-desc"><h4 class="container-desc">{{ $project->description }}</h4></div>
            </div>
            @endforeach
            </div>
        @endif
        @if(count($worlds) > 0)
            @if ($main) <h2> My Current Worlds <a class="button" href="/create-world">+</a></h2> 
            @else <h2> Worlds </h2>
            @endif
            <div class="panel">
            @foreach($worlds as $world)
            <div class="container">
                <img class="max-h-20 min-h-5 h-auto overflow-hidden rounded-t-md" src="https://source.unsplash.com/random/300x200">
                <h3 class="container-title"><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h3>
                <div class="container-desc"><h4>{{ $world->description }}</h4></div>
            </div>
            @endforeach
        @endif
        </div>
</article>
