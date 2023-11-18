<article class="homepage" data-id="{{ $member->id }}">
        <h3> My Assigned Tasks </h3>
        <div class="row">
        @foreach($member->tasks()->orderBy('id')->get() as $task)
        <div class="box"> 
            <h3><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h3>
        </div>
        @endforeach
        </div>

        <h3> My Current Projects </h3>
        <div class="row">
        @foreach($member->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
        <div class="box"> 
            <h3><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h3>
        </div>
        @endforeach
        </div>

        <h3> My Current Worlds <a class="button" href="/create-world">+</a></h3> 
        <div class="row">
        @foreach($member->worlds()->orderBy('id')->get() as $world)
        <div class="box"> 
            <h3><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h3>
        </div>
        @endforeach
        </div>
</article>
