<article class="task" data-id = "{{ $task->id }}">
    <header>
        <h2><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
    </header>
    <p>{{ $task->description }}</p>
    @if($main)
    <h3>This task belongs to: <a href="/projects/{{ $task->project->id }}">{{ $task->project->name }}</a></h3>
    <div class="task-details">
    <div><p>Due At</p> <p class="right">{{ $task->due_date }}</p></div>
    <div><p>Priority</p> <p class="right">{{ $task->priority }}</p></div>
    <div><p>Status</p> <p class="right">{{ $task->status }}</p></div>
    <div><p>Created At</p> <p class="right">{{ $task->created_at }}</p></div>
    <h3>Assigned to</h3>
    <ul>
        @foreach($task->assigned()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
    @if ($task->status != 'Done' && Auth::user()->can('edit', $task))
        @include('form.assignmember', ['task' => $task])
        <form class = "complete-task" method="POST" action="{{ route('complete-task', ['id' => $task->id]) }}">
            @csrf
            @method('POST')
            <button type="submit">Complete Task</button>
        </form>
    @endif
    </div>
    <h4> Comments: </h4>
    <ul>
        @each('partials.comment', $task->comments()->orderBy('id')->get(), 'comment')
    </ul>
    @endif
</article>