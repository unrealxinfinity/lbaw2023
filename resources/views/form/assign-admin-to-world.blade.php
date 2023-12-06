@if($isAdmin)
    <form method="POST" class="demote-admin-from-world">
        @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username" value="{{$member->persistentUser->user->username}}" hidden>
    <input class="button" type="submit" value="Demote">
    </form>
@else
    <form method="POST" class="assign-admin-to-world">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $world->id }}">
    <input type="text" class="username" name="username"  value="{{$member->persistentUser->user->username}}" hidden>
    <input class="button" type="submit" value="Promote">
    </form>
@endif