<form class="assign-admin-to-world mt-5">
    @csrf
   <input type="hidden" class="id" name="id" value="{{ $world->id }}">
   <input type="text" class="username" name="username" placeholder="Username" required>
   <input class="button" type="submit" value="Assign World Admin">
</form>