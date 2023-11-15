<form id="add-member">
    <input type="hidden" class="id" name="id" value="{{ $project->id }}">
    <input type="text" class="username" name="username" placeholder="Username">

    <input type="submit" value="Add a member">
</form>