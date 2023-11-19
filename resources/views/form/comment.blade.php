<form id="add-content" method="POST" action={{ route($route, ['id' => $id]) }}>
    @csrf

    <input type="hidden" name="member" @if (Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>

    <label for="comment-text">Leave a comment!</label>
    @if ($errors->has('text'))
        <span class="error">
          {{ $errors->first('text') }}
        </span>
    @endif
    <input type="text" id="comment-text" name="text" placeholder="Comment" required>
    <input type="submit" value="Comment">
</form>