<form class = "new-task form-outline" method="POST" action="{{ route('create-task') }}">
    <fieldset class="form-post">
        <legend>Create a Task</legend>
        @csrf
        @method('POST')
        <h3 class="my-0 mt-3"><label for="title"> Title <b class="text-red">*</b></label></h3>
        <input type="text" name="title" id="title" placeholder="Title" tabindex="0">
        @if ($errors->has('title'))
            <span class="error">
                {{ $errors->first('title') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"><label for="description"> Description <b class="text-red">*</b></label> </h3>
        <textarea type="text" name="description" id="description"placeholder="Some non-blank text" tabindex="0"> </textarea>
        @if ($errors->has('description'))
            <span class="error">
                {{ $errors->first('description') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"> <label for="status"> Status </label> </h3>
        <select name="status" id="status" tabindex="0">
            <option value="BackLog">BackLog</option>
            <option value="Upcoming">Upcoming</option>
            <option value="In Progress">In Progress</option>
            <option value="Finalizing">Finalizing</option>
            <option value="Done">Done</option>
        </select>

        <h3 class="my-0 mt-3"> <label for="due_at"> Due At <b class="text-red">*</b></label> </h3>
        <input type="date" name="due_at" id="due_at" required tabindex="0">
        @if ($errors->has('due_at'))
            <span class="error">
                {{ $errors->first('due_at') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"> <label for="effort"> Effort <b class="text-red">*</b></label> </h3>
        <input type="number" name="effort" id="effort" placeholder="Effort" required tabindex="0">
        @if ($errors->has('effort'))
            <span class="error">
                {{ $errors->first('effort') }}
            </span>
        @endif
        
        <h3 class="my-0 mt-3"> <label for="priority"> Priority  <b class="text-red">*</b></label> </h3>
        <input type="text" name="priority" id="priority" placeholder="Priority" required tabindex="0">
        @if ($errors->has('priority'))
            <span class="error">
                {{ $errors->first('priority') }}
            </span>
        @endif
        
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <br>
        <button class="button" type="submit" tabindex="0">Create Task</button>
    </fieldset>
</form>