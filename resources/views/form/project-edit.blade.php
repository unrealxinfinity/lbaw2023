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