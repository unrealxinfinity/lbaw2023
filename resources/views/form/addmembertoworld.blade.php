<form class="form-post" id="invite-member">
    @csrf
    <h2>Invite member. </h2> 
    <h3>Do you want to invite someone outside MineMax? <span id="invite-outside-member" class="cursor-pointer">Change Here</span></h3>
    <input type="hidden" class="world_id" name="world_id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" placeholder="Username" required>
    <p class="m-0">What role?</p>
    <select name="type" class="type mt-1" required>
        <option value="false">Member</option>
        <option value="true">World Administrator</option>
    </select>
    
    <input class="button" type="submit" value="Invite">
</form>
<form class="form-post hidden" id="invite-new-member">
    @csrf
    <h2>Invite outside member. </h2> 
    <h3>Do you want to invite someone inside MineMax? <span id="invite-outside-member" class="cursor-pointer">Change Here</span></h3>
    <input type="hidden" class="world_id" name="world_id" value="{{ $world->id }}">
    <input type="text" class="email" name="email" placeholder="example@email.com" required>
    <p class="m-0">What role?</p>
    <select name="type" class="type mt-1" required>
        <option value="false">Member</option>
        <option value="true">World Administrator</option>
    </select>
    
    <input class="button" type="submit" value="Invite">
</form>