<article class="desktop:w-1/3 desktop:mt-8 mt-20 desktop:ml-5">
    <label for="show-details" class="desktop:hidden cursor-pointer m-2">&times;</label>
    @can('edit', $task)
        <form id="edit-task-details" class = "edit-details" method="POST" action="{{ route('edit-details', ['id' => $task->id]) }}">
            <fieldset class="grid grid-cols-3 gap-3">
                <legend>Edit Task Details</legend>
                @csrf
                @method('PUT')
                
                <input type="hidden" class="title" name="title" value="{{ $task->title }}">
                <input type="hidden" class="description" name="description" value="{{ $task->description }}">
                
                <p class="col-span-1 self-center"> <label for="task_due_at"> Due At <b class="text-red">*</b></label> </p>
                <input type="date" class="due_at col-span-2" id="task_due_at" name="due_at" value={{$task->due_at}}>
                @if ($errors->has('due_at'))
                    <span class="error col-span-3">
                        {{ $errors->first('due_at') }}
                    </span>
                @endif
                
                <p class="col-span-1 self-center"> <label for="task-details-priority"> Priority <b class="text-red">*</b></label></p>
                <input type="text" class="priority col-span-2" id="task-details-priority" name="priority" value="{{$task->priority}}">
                @if ($errors->has('priority'))
                    <span class="error col-span-3">
                        {{ $errors->first('priority') }}
                    </span>
                @endif
                <p class="col-span-1 self-center"> <label for="task-details-effort">Effort <b class="text-red">*</b></label> </p>
                <input type="number" class="effort col-span-2" id="task-details-effort" name="effort" value="{{$task->effort}}">
                @if ($errors->has('effort'))
                    <span class="error col-span-3">
                        {{ $errors->first('effort') }}
                    </span>
                @endif
    
                <p class="col-span-1 self-center"> <label for="task-details-status">Status <b class="text-red">*</b></label></p>
                <select name="status" class="status col-span-2" id="task-details-status">
                    <option value="{{$task->status}}" selected="selected" >{{$task->status}}</option>
                    @if($task->status!="BackLog")<option value="BackLog">BackLog</option>@endif
                    @if($task->status!="Upcoming")<option value="Upcoming">Upcoming</option>@endif
                    @if($task->status!="In Progress")<option value="In Progress">In Progress</option>@endif
                    @if($task->status!="Finalizing")<option value="Finalizing">Finalizing</option>@endif
                </select>
                <p class="col-span-1"> Created At</p>
                <p class="col-span-2"> {{ $task->created_at }} </p>
                <button class="button h-fit col-span-1" type="submit">Save</button>
                @if ($task->status != 'Done')
                    <label for="complete-task" class="button">Complete Task</label>
                @endif
            </fieldset>
        </form>
        <form class = "complete-task hidden" method="POST" action="{{ route('complete-task', ['id' => $task->id]) }}">
            <fieldset hidden>
                <legend hidden>Set Task as Completed</legend>
                @csrf
                @method('POST')
                <button id="complete-task" class="hidden" type="submit">Complete Task</button>
            </fieldset>
        </form>
        <h2 class="mt-7 mb-2">Assigned to</h2>
        <ul id="members-assigned" class="members">
            @foreach($task->assigned()->orderBy('id')->get() as $member)
                <li>
                    @include('partials.member', ['member' => $member, 'main' => false])
                </li>
            @endforeach
        </ul>
        @if ($task->status != 'Done')
            <span id="assign-new-member"></span>
            @include('form.assignmember', ['task' => $task])
        @endif
    @else
        <div id="task-see-details" class = "edit-details grid grid-cols-3 gap-3">
                <p class="col-span-1">Due At</p>
                <p class="col-span-2">{{$task->due_at}}</p>
                <p class="col-span-1">Priority</p>
                <p class="col-span-2">{{$task->priority}}</p>
                <p class="col-span-1">Effort</p>
                <p class="col-span-2">{{$task->effort}}</p>
                <p class="col-span-1">Status</p>
                <p class="col-span-2">{{$task->status}}</p>
                <p class="col-span-1">Created At</p>
                <p class="col-span-2">{{$task->created_at}}</p>
            <h2 class="mt-7 mb-2">Assigned to</h2>
            <ul class="members">
                @foreach($task->assigned()->orderBy('id')->get() as $member)
                    @include('partials.member', ['member' => $member, 'main' => false])
                @endforeach
            </ul>
        </div>
    @endcan
</article>