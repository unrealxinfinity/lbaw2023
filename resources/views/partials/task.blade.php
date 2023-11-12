<article class="task" data-id = "{{ $task->id }}">
    <header>
        <h2><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
        <p>{{ $task->description }}</p>
        <p>Due: {{ $task->due_date }}</p>
        <p>Priority: {{ $task->priority }}</p>
        <p>Status: {{ $task->status }}</p>
        <p>Created: {{ $task->created_at }}</p>
    </header>
    <h3>Assigned to:</h3>
    <ul>
        @each('partials.member', $task->assigned()->orderBy('id')->get(), 'member')
    </ul>
