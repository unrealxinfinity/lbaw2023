<form method="POST" action="/worlds/upload/{{ $world->id }}" enctype="multipart/form-data">
    <fieldset class="m-1 my-4 py-2 px-3 w-fit">
        <legend>Upload a new world picture</legend>
        @csrf
        @method('POST')
        
        <div class="relative mobile:h-28 tablet:h-32 desktop:h-40 h-24 aspect-square tablet:mx-5 mx-2 my-1">
            <label for="edit-img">
                <img id='preview-img' class="absolute h-full aspect-square object-cover hover:opacity-50 cursor-pointer" src={{ $world->getImage() }} alt="{{$world->name}} image">
                <h1 class="absolute mobile:h-28 tablet:h-32 desktop:h-40 h-24 aspect-square text-center flex flex-col justify-around pointer-events-none"><span>&#9998;</span></h1>
            </label>
        </div>
        <input id="edit-img" class="hidden" name="file" type="file" required>
        <input name="type" type="hidden" value="world">
        <input tabindex="0" class="button px-1 tablet:ml-5 ml-2 mobile:w-28 tablet:w-32 desktop:w-40 w-24" type="submit" value="Upload world picture">
    </fieldset>
</form>
    
   
<form class="edit-world form-outline outline-none" method="POST" action="{{ route('update-world', ['id' => $world->id]) }}">
    <fieldset class="form-post">
        <legend>Edit world details</legend>
        @csrf
        @method('PUT')

        <input type="hidden" class="world-id" name="id" value="{{ $world->id }}">

        <h3><label for="world-name">Name <b class="text-red">*</b></label></h3>
        <input type="text" class="world-name" id="world-name" name="name" value="{{ $world->name }}" placeholder="Edited Name" required tabindex="0">

        <h3><label for="world-description">Description <b class="text-red">*</b></label></h3>
        <textarea tabindex="0" type="text" class="world-description text-black max-h-40" id="world-description" rows="3" name="description"  placeholder="Some non-blank text" required> {{ $world->description }} </textarea>

        <input tabindex="0" class="button" type="submit" id="submit-{{ $world->id }}" value="Edit World">
    </fieldset>
</form>