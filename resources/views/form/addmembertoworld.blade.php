<form id="add-member-to-world" class="add-member">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" placeholder="Username" required>
    What role?
    <select name="type" class="type" required>
        <option value="false">Member</option>
        <option value="true">World Administrator</option>
    </select>
    
    <input type="submit" value="Add a member">
</form>