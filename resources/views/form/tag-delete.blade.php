@if($type == 'project')
<form method="POST" class="delete-tag" data-id="{{ $project->id }}" data-type="project">
    @csrf
    <input type="hidden" id="tagName" name="tagName" value="{{$tag->name}}" required>
    <input type="hidden" name="tag_id" value="{{ $tag->id }}" required>
    <p class="ml-1"><button id="deleteTagButton" type="button">&times;</button></p>
</form>
@endif

@if($type == 'world')
<form method="POST" class = "delete-tag" data-id="{{ $world->id }}" data-type="world">
    @csrf
    <input type="hidden" id="tagName" name="tagName" value="{{$tag->name}}" required>
    <input type="hidden" name="tag_id" value="{{ $tag->id }}" required>

    <p class="ml-1"><button id="deleteTagButton" type="button">&times;</button></p>
</form>
@endif
@if($type == 'member')
<form method="POST" class = "delete-tag" data-id="{{ $member->name }}" data-type="member">
    @csrf
    <input type="hidden" id="tagName" name="tagName" value="{{$tag->name}}" required>
    <input type="hidden" name="tag_id" value="{{ $tag->id }}" required>

    <p class="ml-1"><button id="deleteTagButton" type="button">&times; </button></p>
</form>
@endif