<article class="task" data-id="{{ $project->id }}">

    <form class = "new-task" method="POST" action="{{ route('create-task') }}">
       @csrf
       @method('POST')

       <input type="text" name="title" placeholder="Title">
       <input type="text" name="description" placeholder="Description">
       <select name="status">
            <option value="BackLog">BackLog</option>
            <option value="Upcoming">Upcoming</option>
            <option value="In Progress">In Progress</option>
            <option value="Finalizing">Finalizing</option>
            <option value="Done">Done</option>
       </select>
       <input type="date" name="due_at" placeholder="Due Date">
       <input type="number" name="effort" placeholder="Effort">
       <input type="text" name="priority" placeholder="Priority">
       <input type="hidden" name="project_id" value="{{ $project->id }}">

       <button type="submit">Create Task</button>
    </form>



</article>