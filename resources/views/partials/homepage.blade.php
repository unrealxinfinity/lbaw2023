<article class="homepage" data-id="{{ $member->id }}">
    @if(count($tasks) > 0)
    <h2> MY ASSIGNED TASKS </h2>
    <div class="panel">
    @foreach($tasks as $task)
    <div class="flex flex-col justify-end min-w-[11rem] w-44 h-32 sm:min-w-[13rem] sm:w-52 sm:h-44 mx-4 my-2 bg-opacity-60 bg-grey rounded" > 
        <div class="h-1/2 md:text-medium text-mediumPhone overflow-hidden px-5 flex flex-col justify-center">
            <h3><a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a>
                > 
            <a href="/projects/{{ $task->project->id }}">{{ $task->project->name }}</a></h3>
        </div>
        @php
            $translateXValue = (strlen($task->title)>15)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
        @endphp
        <div class="title"><h2><a class="{{$translateXValue}}" @if (Auth::user()->persistentUser->type_ != 'Blocked') href="/tasks/{{ $task->id }}" @endif>{{ $task->title }}</a></h2></div>
        <div class="desc"><h4>{{ $task->description }}</h4></div>
    </div>
    @endforeach
    </div>
    @endif
    @if(count($projects) > 0)
    <h2> MY CURRENT PROJECTS </h2>
    <div class="panel">
    @foreach($projects as $project)
   
    <div class="container projectsContainer" data-id="{{$project->id}}">
        <img class="h-1/2 overflow-hidden rounded-t-md " src={{ $project->getImage() }}>
        @php
            $translateXValue = (strlen($project->name)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
        @endphp
        <div class="title"><h2><a class="{{$translateXValue}}" @if (Auth::user()->persistentUser->type_ != 'Blocked') href="/projects/{{ $project->id }}" @endif>{{ $project->name }}</a></h2></div>
        <div class="desc"><h4>{{ $project->description }}</h4></div>
    </div>
    @endforeach
    </div>
    @endif
    @if(count($worlds) > 0)
    <h2> MY CURRENT WORLDS @if (Auth::user()->persistentUser->type_ != 'Blocked') <a class="round-button" href="/create-world">+</a> @endif </h2> 
    <div class="panel">
    @foreach($worlds as $world)
    <div class="container worldsContainer" data-id="{{$world->id}}">
        <img class="h-1/2 overflow-hidden rounded-t-md " src={{ $world->getImage() }}>
        @php
            $translateXValue = (strlen($world->name)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
        @endphp
        <div class="title"><h2><a class="{{$translateXValue}}" @if (Auth::user()->persistentUser->type_ != 'Blocked') href="/worlds/{{ $world->id }}" @endif>{{ $world->name }}</a></h2></div>
        <div class="desc"><h4>{{ $world->description }}</h4></div>
    </div>
    @endforeach
    </div>
    @endif
</article>
