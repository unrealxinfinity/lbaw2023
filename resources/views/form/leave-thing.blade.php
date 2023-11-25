@if($thing instanceof App\Models\World)
    <form method="POST" action="">
        @CSRF
        <button type="submit">Leave World</button>
    </form>
@elseif($thing instanceof App\Models\Project)
    <form method="POST" action="">
        @CSRF
        <button type="submit">Leave Project</button>
    </form>
@endif
