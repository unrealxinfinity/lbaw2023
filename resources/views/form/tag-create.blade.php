<form class = "new-tag form-post" data-id="{{ $project->id }}">
    @csrf
    <h2>Create a tag</h2>
    <input type="text" id="tagName"name="tagName" placeholder="Tag Name" required>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <button class="button" id="createTagButton" type="button">Create Tag</button>
</form>