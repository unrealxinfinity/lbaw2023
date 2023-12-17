<form method="POST" class="flex flex-col" action="{{ route('edit-comment', ['id' => $comment->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="member" @if (Auth::check() && Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>
    <input type="hidden" name="type" value="{{ $type }}">

    <h3 class="my-0 mt-3"><label for ="comment-text">Edit your comment</label> </h3>
    <textarea type="text" id="comment-text" name="text" class="max-h-52 min-h-[5em]" required> {{ $comment->content }} </textarea>

    <div class="flex h-fit items-center mt-2">
        <label for="submit-edit" hidden>Submit Edit</label>
        <input id="submit-edit" class="button" type="submit" value="Edit">

        <label for ="cancel-edit" hidden>Cancel Edit</label>
        <button type="button" class="close-edit link" id="cancel-edit">Cancel</button>
    </div>
</form>