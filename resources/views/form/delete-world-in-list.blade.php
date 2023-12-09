<form id="delete-world-list">
    @csrf
    <input type="hidden" name="id" value={{$world->id}}>
    <button class="px-3 py-1 w-full md:text-medium text-mediumPhone" id="deleteWorldButton" type="submit">Delete World</button>
</form>