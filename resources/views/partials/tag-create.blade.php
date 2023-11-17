<article class="tag" data-id="{{ $project->id }}">

   <form class = "new-task" method="POST" action="{{ route('create-project-tag') }}">
       @csrf
       @method('POST')

       <input type="text" name="tagName" placeholder="Tag Name">
       <button type="submit">Create Tag</button>
   </form>



</article>