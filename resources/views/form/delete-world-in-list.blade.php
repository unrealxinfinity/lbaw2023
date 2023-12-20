<form class="delete-world-list">
    <fieldset>
        <legend class="sr-only">Delete World</legend>
        @csrf
        <input type="hidden" name="id" class="id" value={{$world->id}}>
        <label for ="deleteWorldButton" hidden>Delete World</label>
        <h3><button class="px-3 py-1 w-full md:text-medium text-mediumPhone" id="deleteWorldButton" type="submit" tabindex="0">Delete World</button></h3>
    </fieldset>
</form>