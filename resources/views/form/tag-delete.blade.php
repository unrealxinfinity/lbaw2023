@if($type == 'project')
    <form method="POST" class="delete-tag" data-id="{{ $project->id }}" data-type="project">
        <fieldset>
            <legend class="sr-only">Delete Tag </legend>
            @csrf
            <input type="hidden" id="tagName" name="tagName" value="{{$tag->name}}">
            <input type="hidden" name="tag_id" value="{{ $tag->id }}">
            <p class="ml-1"><button class="deleteTagButton" type="button" tabindex="0">&times;</button></p>
        </fieldset>
    </form>
@endif
@if($type == 'world')
    <form method="POST" class = "delete-tag" data-id="{{ $world->id }}" data-type="world">
        <fieldset>
            <legend class="sr-only">Delete Tag </legend>
            @csrf
            <input type="hidden" id="tagName" name="tagName" value="{{$tag->name}}">
            <input type="hidden" name="tag_id" value="{{ $tag->id }}">

            <p class="ml-1"><button class="deleteTagButton" type="button" tabindex="0">&times;</button></p>
        </fieldset>
    </form>
@endif
@if($type == 'member')
    <form method="POST" class = "delete-tag" data-id="{{ $member->name }}" data-type="member">
        <fieldset>
            <legend class="sr-only">Delete Tag </legend>
            @csrf
            <input type="hidden" id="tagName" name="tagName" value="{{$tag->name}}">
            <input type="hidden" name="tag_id" value="{{ $tag->id }}">

            <p class="ml-1"><button class="deleteTagButton" type="button" tabindex="0">&times; </button></p>
        </fieldset>
    </form>
@endif