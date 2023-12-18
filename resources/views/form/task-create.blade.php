<form class = "new-task form-outline" method="POST" action="{{ route('create-task') }}">
    <fieldset class="form-post">
        <legend>Create a Task</legend>
        @csrf
        @method('POST')
        <h3 class="my-0 mt-3"><label for="title"> Title </label></h3>
        <input type="text" name="title" id="title" placeholder="Title">
        @if ($errors->has('title'))
            <span class="error">
                {{ $errors->first('title') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"><label for="description"> Description </h3>
        <textarea type="text" name="description" id="description"placeholder="Description"> </textarea>
        @if ($errors->has('description'))
            <span class="error">
                {{ $errors->first('description') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"> <label for="status"> Status </label> </h3>
        <select name="status" id="status">
            <option value="BackLog">BackLog</option>
            <option value="Upcoming">Upcoming</option>
            <option value="In Progress">In Progress</option>
            <option value="Finalizing">Finalizing</option>
            <option value="Done">Done</option>
        </select>

        <h3 class="my-0 mt-3"> <label for="due_at"> Due At </label> </h3>
        <input type="date" name="due_at" id="due_at" placeholder="Due Date">
        @if ($errors->has('due_at'))
            <span class="error">
                {{ $errors->first('due_at') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"> <label for="effort"> Effort </label> </h3>
        <input type="number" name="effort" id="effort" placeholder="Effort">
        @if ($errors->has('effort'))
            <span class="error">
                {{ $errors->first('effort') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"> <label for="priority"> Priority </label> </h3>
        <input type="text" name="priority" id="priority" placeholder="Priority">
        @if ($errors->has('priority'))
            <span class="error">
                {{ $errors->first('priority') }}
            </span>
        @endif
        
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <br>
        <button class="button" type="submit">Create Task</button>
    </fieldset>
</form>