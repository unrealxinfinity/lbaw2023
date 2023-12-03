<form id="delete-world" method="POST" action="{{ route('delete-world',['id'=> $world->id]) }}">
    @csrf
    @method('DELETE')
    <button class="px-3 py-1 w-full md:text-medium text-mediumPhone" id="deleteWorldButton" type="submit">Delete World</button>
</form>