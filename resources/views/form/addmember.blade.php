<form id="add-member" class="add-member form-outline">
    <fieldset class="form-post">
        <legend>Add Member</legend>
        @csrf
        <input type="hidden" class="id" name="id" value="{{ $project->id }}">
    
        <h3 class="my-0 mt-3"> <label for="username">Username <b class="text-red">*</b></label> </h3>
        <input type="text" class="username" name="username" id="username" placeholder="Username" required>
    
        <h3 class="my-0 mt-3"> <label for="type">Role</label> </h3>
        <select name="type" class="type" id="type">
            <option value="Member">Member</option>
            <option value="Project Leader">Project Leader</option>
        </select>
    
        <label for="add-member-submit" hidden>submit</label>
        <input class="button" type="submit" id="add-member-submit" value="Add a member">
    </fieldset>
</form>