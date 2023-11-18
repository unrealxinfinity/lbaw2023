<article class="task" data-id = "{{ $task->id }}">
    @if($main)
        <p><a href="/">Home</a> > <a href="/worlds/{{ $task->project->world->id }}">{{ $task->project->world->name }}</a> > <a href="/projects/{{ $task->project->id }}"> {{ $task->project->name }}</a> > <a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></p>
    @endif
    <header>
        <h2><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
    </header>
    <p>{{ $task->description }}</p>
    @if($main)
    <h3>This task belongs to: <a href="/projects/{{ $task->project->id }}">{{ $task->project->name }}</a></h3>
    <div class="task-details">
        <form class = "edit-details" method="POST" action="{{ route('edit-details', ['id' => $task->id]) }}">
            @csrf
            @method('POST')
            <input type="hidden" class="title" name="title" value="{{ $task->title }}">
            <input type="hidden" class="description" name="description" value="{{ $task->description }}">
            <div>
                <p>Due At</p>
                <input type="date" class="due_at" name="due_at" value={{$task->due_at}}>
            </div>
            <div>
                <p>Priority</p>
                <input type="text" class="priority" name="priority" value="{{$task->priority}}">
            </div>
            <div>
                <p>Effort</p>
                <input type="number" class="effort" name="effort" value="{{$task->effort}}">
            </div>
            <div>
                <p>Status</p>
                <select name="status" class="status" value="{{$task->status}}">
                    <option value="{{$task->status}}" selected="selected" >{{$task->status}}</option>
                    @if($task->status!="BackLog")<option value="BackLog">BackLog</option>@endif
                    @if($task->status!="Upcoming")<option value="Upcoming">Upcoming</option>@endif
                    @if($task->status!="In Progress")<option value="In Progress">In Progress</option>@endif
                    @if($task->status!="Finalizing")<option value="Finalizing">Finalizing</option>@endif
                </select>
            </div>
            <div>
                <p>Created At</p>
                <p> {{ $task->created_at }} </p>
            </div>
            <div>
            <button type="submit">Save</button>
        </form>
        @if ($task->status != 'Done' && Auth::user()->can('edit', $task))
        <form class = "complete-task" method="POST" action="{{ route('complete-task', ['id' => $task->id]) }}">
            @csrf
            @method('POST')
            <button type="submit">Complete Task</button>
        </form>
        @endif
    </div>
        <h3>Assigned to</h3>
        <ul>
            @foreach($task->assigned()->orderBy('id')->get() as $member)
                @include('partials.member', ['member' => $member, 'main' => false])
            @endforeach
        </ul>
        @if ($task->status != 'Done' && Auth::user()->can('edit', $task))
            @include('form.assignmember', ['task' => $task])
        @endif
    </div>
    <h4> Comments: </h4>
    <ul>
        @each('partials.comment', $task->comments()->orderBy('id')->get(), 'comment')
    </ul>
    @endif
</article>