<form id="assign-member">
    @csrf
   <input type="hidden" class="id" name="id" value="{{ $task->id }}">
   <input type="text" class="username" name="username" placeholder="Username">
   <input type="submit" value="Assign member">
</form>