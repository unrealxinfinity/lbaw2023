<article class="task" data-id = "{{ $task->id }}">
    <header>
        <h2><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
    </header>
    <p>{{ $task->description }}</p>
    @if($main)
    <div class="task-details" >
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
    </div>
    @endif
