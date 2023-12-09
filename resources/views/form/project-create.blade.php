<form action="{{ route('create-project') }}" id="new-project" class="form-post" method="POST">
  <h2>Create a New Project</h2>
      @csrf
      @method('POST')

      <input type="hidden" name="world_id" value="{{ $world->id }}">
      <input type="text" name="name" placeholder="New Project Name">
      @if ($errors->has('name'))
      <span class="error">
        {{ $errors->first('name') }}
      </span>
      @endif
      <input type="text" name="description" placeholder="Description">
      @if ($errors->has('description'))
      <span class="error">
        {{ $errors->first('description') }}
      </span>
      @endif

      <button class="button" type="submit">Create</button>
  </form>