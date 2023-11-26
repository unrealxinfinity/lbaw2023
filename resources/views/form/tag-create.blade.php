<form class = "new-tag mt-5" data-id="{{ $project->id }}">
    @csrf
    <input type="text" id="tagName"name="tagName" placeholder="Tag Name" required>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <button class="button" type="submit">Create Tag</button>
</form>