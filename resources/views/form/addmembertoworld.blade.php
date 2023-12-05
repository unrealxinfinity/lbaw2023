<form class="form-post" action={{ route ('invite-world', ['id' => $world->id]) }} method="POST">
    @csrf
    @method('POST')
    Invite member:
    <input type="text" class="username" name="username" placeholder="Username" required>
    What role?
    <select name="type" class="type" required>
        <option value="false">Member</option>
        <option value="true">World Administrator</option>
    </select>
    
    <input class="button" type="submit" value="Invite">
</form>