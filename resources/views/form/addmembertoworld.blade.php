<form class="form-outline" id="invite-member">
    <fieldset class="form-post">
        <legend>Invite Member</legend>
        @csrf
        <h3>Do you want to invite someone outside MineMax? <span id="invite-outside-member" class="cursor-pointer text-green underline">Change Here</span></h3>
        <input type="hidden" class="world_id" name="world_id" value="{{ $world->id }}">
    
        <h3 class="my-0 mt-3"> <label for="username">Username</label> </h3>
        <input type="text" class="username" name="username" id="username" placeholder="Username" required>
        
        <h3 class="my-0 mt-3"> <label for="choose-role">Role</label> </h3>
        <select id="choose-role" name="type" class="type mt-1" required>
            <option value="false">Member</option>
            <option value="true">World Administrator</option>
        </select>
        
        <input class="button" type="submit" value="Invite">
    </fieldset>
</form>
<form class="form-outline hidden" id="invite-new-member">
    <fieldset class="form-post">
        <legend>Invite outside member</legend>
        @csrf
        <h3>Do you want to invite someone inside MineMax? <span id="invite-outside-member" class="cursor-pointer text-green underline">Change Here</span></h3>
        <input type="hidden" class="world_id" name="world_id" value="{{ $world->id }}">
    
        <h3 class="my-0 mt-3"> <label for="email">Email</label> </h3>
        <input type="text" class="email" name="email" id="email" placeholder="example@email.com" required>
        <h3 class="my-0 mt-3"> <label for="choose-role">Role</label> </h3>
        <select id="choose-role" name="type" class="type mt-1" required>
            <option value="false">Member</option>
            <option value="true">World Administrator</option>
        </select>
        
        <input class="button" type="submit" value="Invite">
    </fieldset>
</form>