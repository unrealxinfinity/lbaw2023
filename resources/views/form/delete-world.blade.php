<form class ="delete-world form-post" method="POST" action="{{ route('delete-world',['id'=> $world->id]) }}">
    @csrf
    @method('DELETE')

    <button class="button" id="deleteWorldButton" type="submit">Delete World</button>
</form>