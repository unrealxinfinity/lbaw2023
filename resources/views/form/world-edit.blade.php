<form class="edit-world form-post outline-none" method="POST" action="{{ route('update-world', ['id' => $world->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" class="world-id" name="id" value="{{ $world->id }}">
    <input type="text" class="world-name" name="name" value="{{ $world->name }}" placeholder="Name" required>
    <textarea type="text" class="world-description text-black max-h-40" rows="6" name="description"  placeholder="Description" required> {{ $world->description }} </textarea>

    <input class="button" type="submit" id="submit-{{ $world->id }}" value="Edit World">
</form>