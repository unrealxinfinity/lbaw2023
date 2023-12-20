<form id="add-content" method="POST" action={{ route($route, ['id' => $id]) }} class="form-outline">
  <fieldset class="form-post">
    <legend>Leave a Comment!</legend>
    @csrf

    <input type="hidden" name="member" @if (Auth::user()->persistentUser->type_ === 'Member') value="{{ Auth::user()->persistentUser->member->id }}" @endif>
    <input type="hidden" name="type" value="{{ $type }}">

    <h2><label for="comment-text-area">Comment</label></h2>
    @if ($errors->has('text'))
        <span class="error">
          {{ $errors->first('text') }}
        </span>
    @endif

    <textarea type="text" id="comment-text-area" name="text" class="max-h-52 min-h-[5em]" placeholder="Some non-blank text" required tabindex="0"></textarea>

    <label for="submit-comment" hidden>Submit Comment</label>
    <input id="submit-comment" class="button" type="submit" value="Comment" tabindex="0">
  </fieldset>
</form>