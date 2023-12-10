@if ($isAdmin)
    <form method="POST" class="demote-admin-from-world" data-id="{{ $member->id }}">
        @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" value="{{$member->persistentUser->user->username}}" hidden>
    <input class="button bg-grey p-0 px-2" type="submit" value="Demote">
    </form>
@else
    <form method="POST" class="assign-admin-to-world" data-id="{{ $member->id }}">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username"  value="{{$member->persistentUser->user->username}}" hidden>
    <input class="button bg-grey p-0 px-2" type="submit" value="Promote">
    </form>
@endif