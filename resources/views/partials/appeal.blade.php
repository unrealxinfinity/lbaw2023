<form class="form-post grid grid-lines-4 grid-cols-2 gap-4">
    @csrf
    @include('partials.member', ['member' => $appeal->member, 'main' => false, 'appeal' => false])
    <h2 class="row-start-2 col-span-2">Reason for appeal</h2>
    <p class="row-start-3 col-span-2">{{ $appeal->text }}</p>
    <button class="button col-span-1 row-start-4 min-w-1/2 max-w-1/2 justify-self-end" type="submit" formmethod="POST" formaction="{{ route('unblock-member', ['username' => $appeal->member->persistentUser->user->username]) }}">Accept Appeal</button>
    <button class="button col-span-1 row-start-4 min-w-1/4 max-w-1/2" type="submit" formmethod="POST" formaction="{{ route('deny-appeal', ['id' => $appeal->id]) }}">Deny Appeal</button>
</form>