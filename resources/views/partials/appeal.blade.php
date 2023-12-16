<form class="form-post grid grid-lines-4 grid-cols-2">
    @include('partials.member', ['member' => $appeal->member, 'main' => false, 'appeal' => false])
    <h3 class="row-start-2 col-span-2">Reason for appeal</h3>
    <p class="row-start-3 col-span-2">{{ $appeal->text }}</p>
    <button class="button col-span-1" type="submit" formmethod="POST" formaction="{{ route('unblock-member', ['username' => $appeal->member->persistentUser->user->username]) }}">Accept Appeal</button>
    <button class="button col-span-1" type="submit" formmethod="POST" formaction="{{ route('deny-appeal', ['id' => $appeal->id]) }}">Deny Appeal</button>
</form>