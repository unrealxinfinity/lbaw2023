<form class="form-outline">
    <fieldset class="grid grid-lines-4 grid-cols-2 gap-4 mobile:p-5 p-2">
        <legend>Manage User Appeal Status</legend>
        @csrf
        @include('partials.member', ['member' => $appeal->member, 'main' => false, 'appeal' => false])
        <h2 class="row-start-2 col-span-2">Reason for appeal</h2>
        <p class="row-start-3 col-span-2">{{ $appeal->text }}</p>
        <button class="button col-span-1 row-start-4 mobile:min-w-1/2 min-w-full mobile:max-w-1/2 justify-self-end" type="submit" formmethod="POST" formaction="{{ route('unblock-member', ['username' => $appeal->member->persistentUser->user->username]) }}">Accept Appeal</button>
        <button class="button col-span-1 row-start-4 mobile:max-w-1/2" type="submit" formmethod="POST" formaction="{{ route('deny-appeal', ['id' => $appeal->id]) }}">Deny Appeal</button>
    </fieldset>
</form>