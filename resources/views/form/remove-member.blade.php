@if($thing instanceof App\Models\World)
    @if(Auth::user()->persistentUser->member->id !== $member->id)
        <form class="{{$prefix . 'remove-member-world'}}" data-id="{{ $member->id }}">
            <fieldset>
                <legend class="sr-only">Remove Member</legend>
                @CSRF
                <input type="hidden" class="id" name="id" value={{ $thing->id}}>
                <input type="hidden" class="username" name="username" value={{ $member->persistentUser->user->username}}>
                <button type="submit" class="text-red" tabindex="0" title="Remove Member"> &times; </button>
            </fieldset>
        </form>
    @endif
@elseif($thing instanceof App\Models\Project)
    @if (Auth::user()->persistentUser->member->id !== $member->id)
        <form class="{{$prefix . 'remove-member-project'}}" data-id="{{ $member->id }}">
            <fieldset>
                <legend class="sr-only">Remove Member</legend>
                @CSRF
                <input type="hidden" class="id" value={{ $thing->id}}>
                <input type="hidden" class="username" value={{ $member->persistentUser->user->username }}>
                <button type="submit" class ="text-red" tabindex="0" title="Remove Member"> &times; </button>
            </fieldset>
        </form>
    @endif
@elseif($thing instanceof App\Models\Task)
    <form class="{{$prefix . 'remove-member-task'}}" data-id="{{ $member->id }}">
        <fieldset>
            <legend class="sr-only">Remove Member</legend>
            @CSRF
            <input type="hidden" class="id" value={{ $thing->id}}>
            <input type="hidden" class="username" value={{ $member->persistentUser->user->username }}>
            <button type="submit" class ="text-red" tabindex="0" title="Remove Member"> &times; </button>
        </fieldset>
    </form>
@endif
