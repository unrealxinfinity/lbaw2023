<form class="form-post" action="invite-world">
    @csrf
    Invite member:
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" placeholder="Username" required>
    What role?
    <select name="type" class="type" required>
        <option value="false">Member</option>
        <option value="true">World Administrator</option>
    </select>
    
    <input class="button" type="submit" value="Invite">
</form>