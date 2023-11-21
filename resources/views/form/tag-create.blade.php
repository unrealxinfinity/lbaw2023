<article class="tag" >

   <form class = "new-tag" data-id="{{ $project->id }}">
       @csrf
       <input type="text" id="tagName"name="tagName" placeholder="Tag Name" required>
       <input type="hidden" name="project_id" value="{{ $project->id }}">
       <input type="button" id="createTagButton" value='Create Tag'>
   </form>

</article>