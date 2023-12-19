<form id="assign-member" class="add-member mt-5">
    <fieldset>
        <legend>Assign a member</legend>
        @csrf
        <input type="hidden" class="id" name="id" value="{{ $task->id }}">
    
        <h3 class="my-0 mt-3"> <label for="username">Username <b class="text-red">*</b></label> </h3>
        <input type="text" class="username" name="username" placeholder="Username" required>
       
        <label for="submit-assign" hidden>Submit assign member</label>
        <input class="button" type="submit" id="submit-assign" value="Assign member">
    </fieldset>
</form>