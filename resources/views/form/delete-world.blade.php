<form id="delete-world" method="POST" action="{{ route('delete-world',['id'=> $world->id]) }}">
    <fieldset>
        <legend class="sr-only">Delete World From</legend>
        @csrf
        @method('DELETE')
        <label for ="deleteWorldButton" hidden>Delete World</label>
        <h3><button class="px-3 py-1" id="deleteWorldButton" type="submit">Delete World</button></h3>
    </fieldset>
    
</form>