<article class="task-details">
    <form class = "edit-details" method="POST" action="{{ route('edit-details', ['id' => $task->id]) }}">
        @csrf
        @method('POST')
        <input type="hidden" class="title" name="title" value="{{ $task->title }}">
        <input type="hidden" class="description" name="description" value="{{ $task->description }}">
        <div id="Due At">
            <p>Due At</p>
            <input type="date" class="due_at" name="due_at" value={{$task->due_at}}>
        </div>
        <div id="Priority">
            <p>Priority</p>
            <input type="text" class="priority" name="priority" value="{{$task->priority}}">
        </div>
        <div id="Effort">
            <p>Effort</p>
            <input type="number" class="effort" name="effort" value="{{$task->effort}}">
        </div>
        <div id="Status">
            <p>Status</p>
            <select name="status" class="status" value="{{$task->status}}">
                <option value="{{$task->status}}" selected="selected" >{{$task->status}}</option>
                @if($task->status!="BackLog")<option value="BackLog">BackLog</option>@endif
                @if($task->status!="Upcoming")<option value="Upcoming">Upcoming</option>@endif
                @if($task->status!="In Progress")<option value="In Progress">In Progress</option>@endif
                @if($task->status!="Finalizing")<option value="Finalizing">Finalizing</option>@endif
            </select>
        </div>
        <div id="Created At">
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
    <ul class="members">
        @foreach($task->assigned()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
    @if ($task->status != 'Done' && Auth::user()->can('edit', $task))
        @include('form.assignmember', ['task' => $task])
    @endif
</article>