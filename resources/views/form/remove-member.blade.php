@if($thing instanceof App\Models\World)
    <form id ="remove-member-world">
        @CSRF
        <input type="hidden" class="world_id" value={{ $thing->id}}>
        <input type="hidden" class="username" value={{ $member->username}}>
        <input type="submit" value="X">
    </form>
@elseif($thing instanceof App\Models\Project)
    <form id="remove-member-project">
        @CSRF
        <input type="hidden" class="world_id" value={{ $thing->id}}>
        <input type="hidden" class="username" value={{ $member->username}}>
        <input type="submit" value="X">
    </form>
@endif
