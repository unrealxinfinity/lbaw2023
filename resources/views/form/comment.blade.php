<form id="add-content" method="POST" action={{ route($route, ['id' => $id]) }} class="form-post">
    @csrf

    <input type="hidden" name="member" @if (Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>
    <input type="hidden" name="type" value="{{ $type }}">

    <h2><label for="comment-text">Leave a comment!</label></h2>
    @if ($errors->has('text'))
        <span class="error">
          {{ $errors->first('text') }}
        </span>
    @endif
    <textarea type="text" id="comment-text" name="text" class="max-h-52 min-h-[5em]" placeholder="Some non-blank text" required></textarea>
    <input class="button" type="submit" value="Comment">
</form>