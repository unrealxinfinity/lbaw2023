<form method="POST" action="/projects/upload/{{ $project->id }}" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div class="mobile:h-28 tablet:h-32 desktop:h-40 h-20 aspect-square tablet:mx-5 mx-2 my-1">
        <label for="edit-img">
            <h1 class="absolute mobile:h-28 tablet:h-32 desktop:h-40 h-20 aspect-square text-center flex flex-col justify-around pointer-events-none"><label>&#9998;</label></h1>
            <img id='preview-img' class="h-full aspect-square hover:opacity-50 object-cover" src={{ $project->getImage() }} alt="{{ $project->name }} image">
        </label>
    </div>
    <input id="edit-img" class="hidden" name="file" type="file" required>
    <input name="type" type="hidden" value="project">
    <input class="button tablet:ml-5 ml-2" type="submit" value="Upload project picture">
</form>
<form class="edit-project form-post outline-none" method="POST" action="{{ route('update-project', ['id' => $project->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" class="project-id" name="id" value="{{ $project->id }}">
    <input type="text" class="project-name" name="name" value="{{ $project->name }}" placeholder="Name" required>
    <select name="status" class="status">
        <option value="{{$project->status}}" selected="selected" >{{$project->status}}</option>
        @if($project->status!="Active")<option value="Active">Active</option>@endif
        @if($project->status!="Archived")<option value="Archived">Archived</option>@endif
    </select>
    <textarea type="text" class="project-description text-black max-h-36" rows="3" name="description"  placeholder="Description" required> {{ $project->description }} </textarea>

    <input class="button" type="submit" id="submit-{{ $project->id }}" value="Edit Project">
</form>