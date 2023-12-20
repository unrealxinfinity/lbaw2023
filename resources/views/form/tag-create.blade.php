@if($type == 'project')
<form class = "new-tag form-outline" data-id="{{ $project->id }}" data-type="project">
    <fieldset class="form-post">
        <legend>Create a Tag</legend>
        @csrf
        <h3 class="my-0 mt-3"> <label for="tagNameProject">Tag Name <b class="text-red">*</b></label> </h3>
        <input type="text" id="tagNameProject" class="tagName" name="tagName" placeholder="New Tag Name" required tabindex="0">
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <button class="button" id="createTagButton" type="button" tabindex="0">Create Tag</button>
    </fieldset>
</form>
@endif

@if($type == 'world')
<form class = "new-tag form-outline" data-id="{{ $world->id }}" data-type="world">
    <fieldset class="form-post">
        <legend>Create a Tag</legend>
        @csrf
        <h3 class="my-0 mt-3"> <label for="tagNameWorld">Tag Name <b class="text-red">*</b></label> </h3>
        <input type="text" id="tagNameWorld" class="tagName" name="tagName" placeholder="New Tag Name" required tabindex="0">
        <input type="hidden" name="world_id" value="{{ $world->id }}">
        <button class="button" id="createTagButton" type="button" tabindex="0">Create Tag</button>
    </fieldset>
    
</form>
@endif
@if($type == 'member')
<form class = "new-tag form-outline" data-id="{{ $member->name }}" data-type="member">
    <fieldset class="form-post">
        <legend>Create a Tag</legend>
        @csrf
        <h3 class="my-0 mt-3"> <label for="tagNameMember">Tag Name <b class="text-red">*</b></label> </h3>
        <input type="text" id="tagNameMember" class="tagName" name="tagName" placeholder="New Tag Name" required tabindex="0">
        <input type="hidden" name="member_id" value="{{ $member->name }}">
        <button class="button" id="createTagButton" type="button" tabindex="0">Create Tag</button>
    </fieldset>
</form>
@endif