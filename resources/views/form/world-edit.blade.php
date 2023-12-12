<form method="POST" action="/worlds/upload/{{ $world->id }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="mobile:h-28 tablet:h-32 desktop:h-40 h-20 aspect-square tablet:mx-5 mx-2 my-1">
        <label for="edit-img">
            <h1 class="absolute mobile:h-28 tablet:h-32 desktop:h-40 h-20 aspect-square text-center flex flex-col justify-around pointer-events-none"><label>&#9998;</label></h1>
            <img id='preview-img' class="h-full aspect-square hover:opacity-50 object-cover" src={{ $world->getImage() }}>
        </label>
    </div>
    <input id="edit-img" class="hidden" name="file" type="file" required>
    <input name="type" type="hidden" value="world">
    <input class="button tablet:ml-5 ml-2" type="submit" value="Upload world picture">
</form>
<form class="edit-world form-post outline-none" method="POST" action="{{ route('update-world', ['id' => $world->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" class="world-id" name="id" value="{{ $world->id }}">
    <input type="text" class="world-name" name="name" value="{{ $world->name }}" placeholder="Name" required>
    <textarea type="text" class="world-description text-black max-h-40" rows="4" name="description"  placeholder="Description" required> {{ $world->description }} </textarea>

    <input class="button" type="submit" id="submit-{{ $world->id }}" value="Edit World">
</form>