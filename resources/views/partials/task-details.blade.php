<article class="md:w-1/3 mt-4">
    <label for="show-details" class="md:hidden cursor-pointer sm:text-big text-bigPhone sm:m-3 m-2 w-fit">&times;</label>
    @if (Auth::user()->can('edit', $task))
    <form class = "edit-details" method="POST" action="{{ route('edit-details', ['id' => $task->id]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" class="title" name="title" value="{{ $task->title }}">
        <input type="hidden" class="description" name="description" value="{{ $task->description }}">
        <div class="flex child:mx-2 child:my-2" id="Due At">
            <p class="pt-1 mr-10">Due At</p>
            <input type="date" class="due_at" name="due_at" value={{$task->due_at}}>
        </div>
        @if ($errors->has('due_at'))
            <span class="error">
                {{ $errors->first('due_at') }}
            </span>
        @endif
        <div class="flex child:mx-2 child:my-2" id="Priority">
            <p class="pt-1">Priority</p>
            <input type="text" class="priority" name="priority" value="{{$task->priority}}">
        </div>
        @if ($errors->has('priority'))
            <span class="error">
                {{ $errors->first('priority') }}
            </span>
        @endif
        <div class="flex child:mx-2 child:my-2" id="Effort">
            <p class="pt-1">Effort</p>
            <input type="number" class="effort" name="effort" value="{{$task->effort}}">
        </div>
        @if ($errors->has('effort'))
            <span class="error">
                {{ $errors->first('effort') }}
            </span>
        @endif
        <div class="flex child:mx-2 child:my-2" id="Status">
            <p class="pt-1">Status</p>
            <select name="status" class="status" value="{{$task->status}}">
                <option value="{{$task->status}}" selected="selected" >{{$task->status}}</option>
                @if($task->status!="BackLog")<option value="BackLog">BackLog</option>@endif
                @if($task->status!="Upcoming")<option value="Upcoming">Upcoming</option>@endif
                @if($task->status!="In Progress")<option value="In Progress">In Progress</option>@endif
                @if($task->status!="Finalizing")<option value="Finalizing">Finalizing</option>@endif
            </select>
        </div>
        <div class="flex child:mx-2 child:my-2" id="Created At">
            <p class="pt-1"> Created At</p>
            <p class="pt-1"> {{ $task->created_at }} </p>
        </div>
        <div class="flex">
        <button class="button" type="submit">Save</button>
    </form>
    @if ($task->status != 'Done')
        <form class = "complete-task" method="POST" action="{{ route('complete-task', ['id' => $task->id]) }}">
            @csrf
            @method('POST')
            <button class="button" type="submit">Complete Task</button>
        </form>
    @endif
        </div>
    <h1 class="mt-5">Assigned to</h1>
    <ul class="members">
        @foreach($task->assigned()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
    @if ($task->status != 'Done')
        @include('form.assignmember', ['task' => $task])
    @endif
    @else
    <div class="flex child:mx-2 child:my-2" id="Due At">
        <p class="pt-1">Due At</p>
        <p>{{$task->due_at}}</p>
    </div>
    <div class="flex child:mx-2 child:my-2" id="Priority">
        <p class="pt-1">Priority</p>
        <p>{{$task->priority}}</p>
    </div>
    <div class="flex child:mx-2 child:my-2" id="Effort">
        <p class="pt-1">Effort</p>
        <p>{{$task->effort}}</p>
    </div>
    <div class="flex child:mx-2 child:my-2" id="Status">
        <p class="pt-1">Status</p>
        <p>{{$task->status}}</p>
    </div>
    <div class="flex child:mx-2 child:my-2" id="Created At">
        <p class="pt-1">Created At</p>
        <p class="pt-1">{{$task->created_at}}</p>
    </div>
    <h1 class="mt-5">Assigned to</h1>
    <ul class="members">
        @foreach($task->assigned()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
    @endif
</article>