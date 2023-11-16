<article class="task" data-id="{{ $project->id }}">

   <form class = "new-task" method="POST" action="{{ route('create-task') }}">
       @csrf
       @method('POST')

       <input type="text" name="title" placeholder="Title">
       <input type="text" name="description" placeholder="Description">
       <input type="text" name="status" placeholder="BackLog">
       <input type="date" name="due_at" placeholder="Due Date">
       <input type="number" name="effort" placeholder="Effort">
       <input type="text" name="priority" placeholder="Priority">
       <input type="hidden" name="project_id" value="{{ $project->id }}">

       <button type="submit">Create Task</button>
   </form>



</article>