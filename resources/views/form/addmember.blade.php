<form id="add-member" class="add-member">
     @csrf
    <input type="hidden" class="id" name="id" value="{{ $project->id }}">
    <input type="text" class="username" name="username" placeholder="Username">
    <select name="type" class="type">
        <option value="Member">Member</option>
        <option value="Project Leader">Project Leader</option>
    </select>

    <input type="submit" value="Add a member">
</form>