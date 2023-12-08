<form method="POST" class="flex flex-col" action="{{ route('edit-comment', ['id' => $comment->id]) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="member" @if (Auth::check() && Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>
    <input type="hidden" name="type" value="{{ $type }}">

    <textarea type="text" id="comment-text" name="text" class="max-h-52 min-h-[5em]" required> {{ $comment->content }} </textarea>
    <div class="flex h-fit items-center mt-2">
        <input class="button" type="submit" value="Edit">
        <button type="button" class="close-edit link">Cancel</button>
    </div>
</form>