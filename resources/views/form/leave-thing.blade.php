@if($thing instanceof App\Models\World)
    <form method="POST" id="leave-world">
        @CSRF
        @method('DELETE')
        <input type="hidden" name="world_id" value="{{ $thing->id }}">
        <input type="hidden" name="username" value="{{ Auth::user()->username }}">
        <button type="submit">Leave World</button>
    </form>
@elseif($thing instanceof App\Models\Project)
    <form method="POST" action="">
        @CSRF
        @method('DELETE')
        <button type="submit">Leave Project</button>
    </form>
@endif
