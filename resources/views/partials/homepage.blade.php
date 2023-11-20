<article class="homepage" data-id="{{ $member->id }}">
        @if(count($tasks) > 0)
            @if ($main) <h3> My Assigned Tasks </h3>
            @else <h2> Assigned Tasks </h2>
            @endif
            <div class="row">
            @foreach($tasks as $task)
            <div class="box"> 
                <h3><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h3>
            </div>
            @endforeach
            </div>
        @endif
        @if(count($projects) > 0)
            @if ($main) <h3> My Current Projects </h3>
            @else <h2> My Projects </h2>
            @endif
            <div class="row">
            @foreach($projects as $project)
            <div class="box"> 
                <h3><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h3>
            </div>
            @endforeach
            </div>
        @endif
        @if(count($worlds) > 0)
            @if ($main) <h3> My Current Worlds <a class="button" href="/create-world">+</a></h3> 
            @else <h2> Worlds </h2>
            @endif
            <div class="row">
            @foreach($worlds as $world)
            <div class="box"> 
                <h3><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h3>
            </div>
            @endforeach
        @endif
        </div>
</article>
