@if($type == 'project')
<form class = "new-tag form-post" data-id="{{ $project->id }}" data-type="project">
    @csrf
    <h2>Create a tag</h2> 
    <h3 class="my-0 mt-3"> <label for="tagNameProject">Tag Name</label> </h3>
    <input type="text" id="tagNameProject" class="tagName" name="tagName" placeholder="Tag Name" required>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <button class="button" id="createTagButton" type="button">Create Tag</button>
</form>
@endif

@if($type == 'world')
<form class = "new-tag form-post" data-id="{{ $world->id }}" data-type="world">
    @csrf
    <h2>Create a tag</h2>
    <h3 class="my-0 mt-3"> <label for="tagNameWorld">Tag Name</label> </h3>
    <input type="text" id="tagNameWorld" class="tagName" name="tagName" placeholder="Tag Name" required>
    <input type="hidden" name="world_id" value="{{ $world->id }}">
    <button class="button" id="createTagButton" type="button">Create Tag</button>
</form>
@endif
@if($type == 'member')
<form class = "new-tag form-post" data-id="{{ $member->name }}" data-type="member">
    @csrf
    <h2>Create a tag</h2>
    <h3 class="my-0 mt-3"> <label for="tagNameMember">Tag Name</label> </h3>
    <input type="text" id="tagNameMember" class="tagName" name="tagName" placeholder="Tag Name" required>
    <input type="hidden" name="member_id" value="{{ $member->name }}">
    <button class="button" id="createTagButton" type="button">Create Tag</button>
</form>
@endif