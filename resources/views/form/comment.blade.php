<form id="add-content" method="POST" action={{ route($route, ['id' => $id]) }} class="form-post">
    @csrf

    <input type="hidden" name="member" @if (Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>
    <input type="hidden" name="type" value="{{ $type }}">

    <h2><label for="comment-text-area">Leave a comment!</label></h2>
    @if ($errors->has('text'))
        <span class="error">
          {{ $errors->first('text') }}
        </span>
    @endif

    <textarea type="text" id="comment-text-area" name="text" class="max-h-52 min-h-[5em]" required></textarea>

    <label for="submit-comment" hidden>Submit Comment</label>
    <input id="submit-comment" class="button" type="submit" value="Comment">
</form>