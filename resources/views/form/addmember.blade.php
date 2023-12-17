<form id="add-member" class="add-member form-post">
    @csrf
    <h2> Add member </h2>
    <input type="hidden" class="id" name="id" value="{{ $project->id }}">

    <h3 class="my-0 mt-3"> <label for="username">Username</label> </h3>
    <input type="text" class="username" name="username" id="username" placeholder="Username" required>

    <h3 class="my-0 mt-3"> <label for="type">Role</label> </h3>
    <select name="type" class="type" id="type">
        <option value="Member">Member</option>
        <option value="Project Leader">Project Leader</option>
    </select>

    <label for="add-member-submit" hidden>submit</label>
    <input class="button" type="submit" id="add-member-submit" value="Add a member">
</form>