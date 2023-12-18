<form method="POST" action="/projects/upload/{{ $project->id }}" enctype="multipart/form-data">
    <fieldset>
        <legend>Upload Project Picture</legend>
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
    </fieldset>
</form>
<form class="edit-project form-post outline-none" method="POST" action="{{ route('update-project', ['id' => $project->id]) }}">
    <fieldset>
        <legend>Edit Project Details</legend>
        @csrf
        @method('PUT')
    
        <input type="hidden" class="project-id" name="id" value="{{ $project->id }}">
        
        <h3 class="my-0 mt-3"> <label for="project-name">Project name</label> </h3>
        <input type="text" id="project-name" class="project-name" name="name" value="{{ $project->name }}" placeholder="Name" required>
        <h3 class="my-0 mt-3"> <label for="project-status">Project status</label> </h3>
        <select name="status" id="project-status" class="status">
            <option value="{{$project->status}}" selected="selected" >{{$project->status}}</option>
            @if($project->status!="Active")<option value="Active">Active</option>@endif
            @if($project->status!="Archived")<option value="Archived">Archived</option>@endif
        </select>
        <h3 class="my-0 mt-3"> <label for="project-description">Project description</label> </h3>
        <textarea type="text" id="project-description" class="project-description text-black max-h-36" rows="3" name="description"  placeholder="Description" required> {{ $project->description }} </textarea>
    
        <input class="button" type="submit" id="submit-{{ $project->id }}" value="Edit Project">
    </fieldset>
</form>