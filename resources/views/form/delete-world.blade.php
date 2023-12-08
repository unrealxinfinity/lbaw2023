<form id="delete-world" method="POST" action="{{ route('delete-world',['id'=> $world->id]) }}">
    @csrf
    @method('DELETE')
    <h3><button class="px-3 py-1" id="deleteWorldButton" type="submit">Delete World</button></h3>
</form>