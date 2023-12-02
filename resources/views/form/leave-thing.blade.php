@if($thing instanceof App\Models\World)
    <form method="POST" action={{ route('leave-world', ['id' => $thing->id, 'username' => Auth::user()->username]) }}>
        @CSRF
        @method('DELETE')
        <input class="button" type="submit" value="Leave World">
    </form>
@elseif($thing instanceof App\Models\Project)
    <form method="POST" action={{ route('leave-project', ['id' => $thing->id, 'username' => Auth::user()->username]) }}>
        @CSRF
        @method('DELETE')
        <button class="button" type="submit">Leave Project</button>
    </form>
@endif
