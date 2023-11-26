<form id="assign-member" class="add-member mt-5">
    @csrf
   <input type="hidden" class="id" name="id" value="{{ $task->id }}">
   <input type="text" class="username" name="username" placeholder="Username" required>
   <input class="button" type="submit" value="Assign member">
</form>