<form method="POST" action="{{ route('edit-comment', ['id' => $comment->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="member" @if (Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>
    <input type="hidden" name="type" value="{{ $type }}">

    <input type="text" id="comment-text" name="text" value="{{ $comment->content }}" required>
    <input class="button" type="submit" value="Edit">
    <button type="button" class="close-edit button">Cancel</button>
</form>