@if($thing instanceof App\Models\World)
    @if(Auth::check() && Auth::user()->persistentUser->member->worlds->contains('id', $thing->id) && Auth::user()->persistentUser->member->worlds->where('id', $thing->id)->first()->pivot->is_admin && Auth::user()->persistentUser->member->id !== $member->id)
        <form id="remove-member-world">
            @CSRF
            <input type="hidden" class="world_id" name="world_id" value={{ $thing->id}}>
            <input type="hidden" class="username" name="username" value={{ $member->persistentUser->user->username}}>
            <input type="submit" value="remove {{ $member->persistentUser->user->username}}">
        </form>
    @endif
@elseif($thing instanceof App\Models\Project)
    <form id="remove-member-project">
        @CSRF
        <input type="hidden" class="world_id" value={{ $thing->id}}>
        <input type="hidden" class="username" value={{ $member->persistentUser->user->username }}>
        <input type="submit" value="X">
    </form>
@endif
