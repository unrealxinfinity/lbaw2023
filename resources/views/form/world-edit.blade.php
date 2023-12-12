<div class="flex sm:h-36 h-24 m-5 mb-10">
                
    <form method="POST" action="/worlds/upload/{{ $world->id }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="sm:h-36 h-24 aspect-square sm:ml-5 ml-1">
            <label for="edit-img">
                <label class="absolute sm:h-36 h-24 aspect-square text-center flex flex-col justify-around pointer-events-none md:text-big text-bigPhone">&#9998;</label>
                <img id='preview-img' class="sm:h-36 h-24 aspect-square hover:opacity-50 object-cover" src={{ $world->getImage() }}>
            </label>
        </div>
        <input id="edit-img" class="hidden" name="file" type="file" required>
        <input name="type" type="hidden" value="world">
        <input class="button w-min" type="submit" value="Upload world picture">
    </form>
</div>
<form class="edit-world form-post outline-none" method="POST" action="{{ route('update-world', ['id' => $world->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" class="world-id" name="id" value="{{ $world->id }}">
    <input type="text" class="world-name" name="name" value="{{ $world->name }}" placeholder="Name" required>
    <textarea type="text" class="world-description text-black max-h-40" rows="4" name="description"  placeholder="Description" required> {{ $world->description }} </textarea>

    <input class="button" type="submit" id="submit-{{ $world->id }}" value="Edit World">
</form>