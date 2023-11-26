<form id="add-member" class="add-member mt-5 flex flex-col child:my-1">
     @csrf
    <input type="hidden" class="id" name="id" value="{{ $project->id }}">
    <input type="text" class="username" name="username" placeholder="Username" required>
    <select name="type" class="type">
        <option value="Member">Member</option>
        <option value="Project Leader">Project Leader</option>
    </select>

    <input class="button" type="submit" value="Add a member">
</form>