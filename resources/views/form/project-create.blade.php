<form action="{{ route('create-project') }}" id="new-project" class="form-post" method="POST">
  <fieldset>
    <h2> <legend>Create a New Project</legend> </h2>
    @csrf
    @method('POST')

    <input type="hidden" name="world_id" value="{{ $world->id }}">

    <h3 class="my-0 mt-3"> <label for="new-project-name">Name</label></h3>
    <input type="text" name="name" id="new-project-name" placeholder="New Project Name">
    @if ($errors->has('name'))
    <span class="error">
      {{ $errors->first('name') }}
    </span>
    @endif

    <h3 class="my-0 mt-3"> <label for="new-project-description">Description</label></h3>
    <textarea type="text" name="description" placeholder="Description" id="new-project-description"> </textarea>
    @if ($errors->has('description'))
    <span class="error">
      {{ $errors->first('description') }}
    </span>
    @endif

    <button class="button" type="submit">Create</button>
  </fieldset>
</form>