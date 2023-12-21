<form class="form-outline" id="invite-member">
    <fieldset class="form-post">
        <legend>Invite Member</legend>
        @csrf
        <h3>Do you want to invite someone outside MineMax? <button tabindex=0 id="invite-outside-member" type="button" class="cursor-pointer text-green underline">Change Here</button></h3>
        <input type="hidden" class="world_id" name="world_id" value="{{ $world->id }}" tabindex="0">
    
        <h3 class="my-0 mt-3"> <label for="username">Username <b class="text-red">*</b></label> </h3>
        <input type="text" class="username" name="username" id="username" placeholder="Username" required tabindex="0">
        
        <h3 class="my-0 mt-3"> <label for="choose-role">Role <b class="text-red">*</b></label> </h3>
        <select id="choose-role" name="type" class="type mt-1" required tabindex="0">
            <option value="" disabled selected>Choose a role</option>
            <option value="false">Member</option>
            <option value="true">World Administrator</option>
        </select>
        
        <input class="button" type="submit" value="Invite" tabindex="0">
    </fieldset>
</form>
<form class="form-outline hidden" id="invite-new-member">
    <fieldset class="form-post">
        <legend>Invite outside member</legend>
        @csrf
        <h3>Do you want to invite someone inside MineMax? <button tabindex=0 id="invite-outside-member" type="button" class="cursor-pointer text-green underline">Change Here</button></h3>
        <input type="hidden" class="world_id" name="world_id" value="{{ $world->id }}" tabindex="0">
    
        <h3 class="my-0 mt-3"> <label for="email">Email <b class="text-red">*</b></label> </h3>
        <input type="text" class="email" name="email" id="email" placeholder="example@email.com" required tabindex="0">
        <h3 class="my-0 mt-3"> <label for="choose-role">Role</label> </h3>
        <select id="choose-role" name="type" class="type mt-1" required tabindex="0">
            <option value="false">Member</option>
            <option value="true">World Administrator</option>
        </select>
        
        <input class="button" type="submit" value="Invite" tabindex="0">
    </fieldset>
</form>