<form action="{{ route('create-project') }}" id="new-project" class="form-outline" method="POST">
  <fieldset class="form-post">
    <legend>Create a New Project</legend>
    @csrf
    @method('POST')

    <input type="hidden" name="world_id" value="{{ $world->id }}">

    <h3 class="my-0 mt-3"> <label for="new-project-name">Name <b class="text-red">*</b></label></h3>
    <input type="text" name="name" id="new-project-name" placeholder="New Project Name" required>
    @if ($errors->has('name'))
    <span class="error">
      {{ $errors->first('name') }}
    </span>
    @endif

    <h3 class="my-0 mt-3"> <label for="new-project-description">Description <b class="text-red">*</b></label></h3>
    <textarea type="text" name="description" id="new-project-description" placeholder="Some non-blank text" required> </textarea>
    @if ($errors->has('description'))
    <span class="error">
      {{ $errors->first('description') }}
    </span>
    @endif

    <button class="button" type="submit">Create</button>
  </fieldset>
</form>