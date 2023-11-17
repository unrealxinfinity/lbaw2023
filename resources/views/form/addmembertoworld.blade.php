<form id="add-member-to-world">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" placeholder="Username">
    Add as a World Admin?<input type="checkbox" class="type" value="false">
    
    <input type="submit" value="Add a member">
</form>