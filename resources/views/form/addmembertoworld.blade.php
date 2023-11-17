<form id="add-member-to-world">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" placeholder="Username">
    <select name="type" class="type">
        <option value="Member">Member</option>
        <option value="World Admin">World Admin</option>
    </select>
    <input type="submit" value="Add a member">
</form>