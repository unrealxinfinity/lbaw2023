<h2>Your account will be deleted in 5 seconds!</h2>
<h4>You can still press "cancel" to keep your account.</h4>
<a class="button" href="/members/{{ $member->persistentUser->user->username }}">Cancel</a>

<form class="hidden" method="POST" id="confirm-deletion" action="/members/{{ $member->persistentUser->user->username }}">
    @csrf
    @method('DELETE')
    <input type="submit" value="Delete account">
</form>