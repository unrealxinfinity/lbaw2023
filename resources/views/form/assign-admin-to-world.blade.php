@if ($isAdmin)
    <form method="POST" class="demote-admin-from-world" data-id="{{ $member->id }}">
        <fieldset>
            <legend class="sr-only">Demote World Admin to World Member</legend>
            @csrf
            <input type="hidden" class="id" name="id" value="{{ $world->id }}">
            <input type="text" class="username" name="username" value="{{$member->persistentUser->user->username}}" hidden>
    
            <label for="{{$prefix . 'submit-demote'}}" class="sr-only">Submit demote admin</label>
            <input id="{{$prefix . 'submit-demote'}}" class="button bg-grey p-0 px-2" type="submit" value="Demote" tabindex="0">
        </fieldset>
    </form>
@else
    <form method="POST" class="assign-admin-to-world" data-id="{{ $member->id }}">
        <fieldset>
            <legend class="sr-only">Promote World Member to World Admin</legend>
            @csrf
            <input type="hidden" class="id" name="id" value="{{ $world->id }}">
            <input type="text" class="username" name="username"  value="{{$member->persistentUser->user->username}}" hidden>
    
            <input id="{{$prefix . 'submit-promote'}}" class="button bg-grey p-0 px-2" type="submit" value="Promote" tabindex="0">
        </fieldset>
    </form>
@endif