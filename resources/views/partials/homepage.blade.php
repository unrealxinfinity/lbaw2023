<article class="homepage" data-id="{{ $member->id }}">
    @if(count($tasks) > 0)
    <h2 class="decoration-green underline underline-offset-4 decoration-2"> MY ASSIGNED TASKS </h2>
    <div class="panel">
    @foreach($tasks as $task)
    <div class="flex flex-col justify-end m-1 min-w-[11rem] w-44 h-32 tablet:min-w-[13rem] tablet:w-52 tablet:h-44 bg-black rounded outline outline-1 outline-white/10"> 
        <div class="h-1/2 overflow-hidden px-5 flex flex-col justify-center">
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
    <h2 class="decoration-green underline underline-offset-4 decoration-2"> MY CURRENT PROJECTS </h2>
    <div class="panel">
    @foreach($projects as $project)
   
    <div class="container projectsContainer" data-id="{{$project->id}}">
        <img class="h-1/2 overflow-hidden rounded-t-md" src={{ $project->getImage() }}>
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
    <div class="flex">
        <h2 class="decoration-green underline underline-offset-4 decoration-2"> MY CURRENT WORLDS</h2>
        @if (Auth::user()->persistentUser->type_ == 'Member') <h2><a class="outline outline-1 tablet:px-1.5 px-1 ml-3" href="/create-world">+</a></h2> @endif  
    </div>
    <div class="panel">
    @foreach($worlds as $world)
    <div class="container worldsContainer" data-id="{{$world->id}}">
        <img class="h-1/2 overflow-hidden rounded-t-md " src={{ $world->getImage() }}>
        @php
            $translateXValue = (strlen($world->name)>25)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
        @endphp
        <div class="title"><h2><a class="{{$translateXValue}}" @if (Auth::user()->persistentUser->type_ != 'Blocked') href="/worlds/{{ $world->id }}" @endif>{{ $world->name }}</a></h2></div>
        <div class="desc"><h4>{{ $world->description }}</h4></div>
    </div>
    @endforeach
    </div>
    @endif
</article>
