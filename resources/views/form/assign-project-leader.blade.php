@if ($isPromote == false)
    <form method="POST" class="demote-project-leader" data-id="{{ $member->id }}">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $project->id }}">
    <input type="text" class="username" name="username" value="{{$member->persistentUser->user->username}}" hidden>
    <input class="button bg-grey p-0 px-2" type="submit" value="Demote">
    </form>
@else
    <form method="POST" class="assign-project-leader" data-id="{{ $member->id }}">
    @csrf
    <input type="hidden" class="id" name="id" value="{{ $project->id }}">
    <input type="text" class="username" name="username"  value="{{$member->persistentUser->user->username}}" hidden>
    <input class="button bg-grey p-0 px-2" type="submit" value="Promote">
    </form>
@endif