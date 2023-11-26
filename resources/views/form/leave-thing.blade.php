@if($thing instanceof App\Models\World)
    <form method="POST" id="leave-world" action={{ route('leave-world', ['id' => $thing->id, 'username' => Auth::user()->username]) }}>
        @CSRF
        @method('DELETE')
        <input type="submit" value="Leave World">
    </form>
@elseif($thing instanceof App\Models\Project)
    <form method="POST" action="">
        @CSRF
        @method('DELETE')
        <button type="submit">Leave Project</button>
    </form>
@endif
