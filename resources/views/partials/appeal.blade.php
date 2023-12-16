<form>
    @include('partials.member', ['member' => $appeal->member, 'main' => false, 'appeal' => false])
    <h3>Reason for appeal</h3>
    <p>{{ $appeal->text }}</p>
    <button type="submit" formmethod="POST" formaction="{{ route('unblock-member', ['username' => $appeal->member->persistentUser->user->username]) }}">Accept Appeal</button>
    <button type="submit" formmethod="POST" formaction="{{ route('deny-appeal', ['id' => $appeal->id]) }}">Deny Appeal</button>
</form>