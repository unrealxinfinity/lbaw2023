<form class = "new-tag form-post" data-id="{{ $project->id }}">
    @csrf
    Create a tag:
    <input type="text" id="tagName"name="tagName" placeholder="Tag Name" required>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <button class="button" id="createTagButton" type="button">Create Tag</button>
</form>