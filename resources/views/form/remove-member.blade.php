@if($thing instanceof App\Models\World)
    @if(Auth::user()->persistentUser->member->id !== $member->id)
        <form id="remove-member-world" data-id="{{ $member->id }}">
            @CSRF
            <input type="hidden" class="id" name="id" value={{ $thing->id}}>
            <input type="hidden" class="username" name="username" value={{ $member->persistentUser->user->username}}>
            <button type="submit"> &times; </button>
        </form>
    @endif
@elseif($thing instanceof App\Models\Project)
    @if (Auth::user()->persistentUser->member->id !== $member->id)
        <form id="remove-member-project" data-id="{{ $member->id }}">
            @CSRF
            <input type="hidden" class="id" value={{ $thing->id}}>
            <input type="hidden" class="username" value={{ $member->persistentUser->user->username }}>
            <button type="submit"> &times; </button>
        </form>
    @endif
@endif
