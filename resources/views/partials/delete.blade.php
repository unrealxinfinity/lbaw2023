<h2 class="basis-auto">Your account will be deleted in 5 seconds!</h2>
<h4 class="basis-auto">You can still press "cancel" to keep your account.</h4>
<a class="button basis-auto" href="/members/{{ $member->persistentUser->user->username }}">Cancel</a>

<form class="hidden" method="POST" id="confirm-deletion" action="/members/{{ $member->persistentUser->user->username }}">
    @csrf
    @method('DELETE')
    <input type="submit" value="Delete account">
</form>