<form method="POST" action="/worlds/upload/{{ $world->id }}" enctype="multipart/form-data">
    <fieldset>
        <legend>Upload a new world picture</legend>
        @csrf
        @method('POST')
        
        <div class="mobile:h-28 tablet:h-32 desktop:h-40 h-20 aspect-square tablet:mx-5 mx-2 my-1">
            <label for="edit-img">
                <h1 class="absolute mobile:h-28 tablet:h-32 desktop:h-40 h-20 aspect-square text-center flex flex-col justify-around pointer-events-none"><label>&#9998;</label></h1>
                <img id='preview-img' class="h-full aspect-square hover:opacity-50 object-cover" src={{ $world->getImage() }} alt="{{$world->name}} image">
            </label>
        </div>
        <input id="edit-img" class="hidden" name="file" type="file" required>
        <input name="type" type="hidden" value="world">
        <input class="button tablet:ml-5 ml-2" type="submit" value="Upload world picture">
    </fieldset>
</form>
    
   
<form class="edit-world form-post outline-none" method="POST" action="{{ route('update-world', ['id' => $world->id]) }}">
    <fieldset class="form-post">
        <legend>Edit world details</legend>
        @csrf
        @method('PUT')

        <input type="hidden" class="world-id" name="id" value="{{ $world->id }}">

        <label for="world-name">Name</label>
        <input type="text" class="world-name" id="world-name" name="name" value="{{ $world->name }}" placeholder="Name" required>

        <label for="world-description">Description</label>
        <textarea type="text" class="world-description text-black max-h-40" id="world-description" rows="4" name="description"  placeholder="Description" required> {{ $world->description }} </textarea>

        <input class="button" type="submit" id="submit-{{ $world->id }}" value="Edit World">
    </fieldset>
</form>