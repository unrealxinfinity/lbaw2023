<form class="edit-world form-post outline-none" method="POST" action="{{ route('appeal', ['id' => $member]) }}">
    @csrf
    @method('POST')

    <textarea type="text" class="world-description text-black max-h-40" rows="4" name="text"  placeholder="Why do you think you should be unblocked?" required></textarea>

    <input class="button" type="submit" value="Appeal">
</form>