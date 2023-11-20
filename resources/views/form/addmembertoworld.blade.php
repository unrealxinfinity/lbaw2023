<form id="add-member-to-world" class="add-member">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" placeholder="Username" required>
    Add as a World Admin?<input type="checkbox" class="type" name="type" value="false">
    
    <input type="submit" value="Add a member">
</form>