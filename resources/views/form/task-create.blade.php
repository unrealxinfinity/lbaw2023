<form class = "new-task form-post" method="POST" action="{{ route('create-task') }}">
    @csrf
    @method('POST')
    <h2>Create a task</h2>
    <input type="text" name="title" placeholder="Title -> required">
    @if ($errors->has('title'))
        <span class="error">
            {{ $errors->first('title') }}
        </span>
    @endif
    
    <input type="text" name="description" placeholder="Description -> required" required>
    @if ($errors->has('description'))
        <span class="error">
            {{ $errors->first('description') }}
        </span>
    @endif
    
    <select name="status">
        <option value="BackLog">BackLog</option>
        <option value="Upcoming">Upcoming</option>
        <option value="In Progress">In Progress</option>
        <option value="Finalizing">Finalizing</option>
        <option value="Done">Done</option>
    </select>
    
    <input type="date" name="due_at" placeholder="Due Date" class="">
    <p >*Due Date is required*</p>
    @if ($errors->has('due_at'))
        <span class="error">
            {{ $errors->first('due_at') }}
        </span>
    @endif
    

    <input type="number" name="effort" placeholder="Effort -> required" required>
    @if ($errors->has('effort'))
        <span class="error">
            {{ $errors->first('effort') }}
        </span>
    @endif
    

    <input type="text" name="priority" placeholder="Priority -> required" required>
    @if ($errors->has('priority'))
        <span class="error">
            {{ $errors->first('priority') }}
        </span>
    @endif
    
    <input type="hidden" name="project_id" value="{{ $project->id }}">

    <button class="button" type="submit">Create Task</button>
</form>