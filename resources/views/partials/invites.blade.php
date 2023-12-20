@if($type === 'invite')
    <article class="flex justify-between h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded">
        <img src={{$invite->world->getImage()}} alt="{{$invite->world->name}} image" class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="text-white">You have been invited to join <a href="worlds/{{$invite->world_id}}">"{{$invite->world->name}}"</a></h2>
            <h4 class="text-white">Do you wish to join?</h4>
        </div>
        <div class="flex mobile:flex-row flex-col">
            <form class="self-center" action={{ route ('join-world', ['id' => $invite->world_id]) }} method="POST">
                <fieldset class="mobile:p-2 py-1">
                    <legend class="sr-only">Accept Invite to Join World</legend>
                    @csrf
                    @method('POST')
                    <input type="hidden" class="token" name="token" value="{{ $invite->token }}">
                    <input type="hidden" class="acceptance" name="acceptance" value=1>
                    <button class="button">&#10003;</button>
                </fieldset>
            </form>
            <form class="self-center" action={{ route ('join-world', ['id' => $invite->world_id]) }} method="POST">
                <fieldset class="mobile:p-2 py-1">
                    <legend class="sr-only">Reject Invite to Join World</legend>
                    @csrf
                    @method('POST')
                    <input type="hidden" class="token" name="token" value="{{ $invite->token }}">
                    <input type="hidden" class="acceptance" name="acceptance" value=0>
                    <button class="button">&#10005;</button>
                </fieldset>
            </form>
        </div>
    </article>
@elseif($type === 'request')
    <article class="flex justify-between h-fit p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded friend-request" data-id="{{$request->id}}">
        <img class="mobile:h-14 tablet:h-16 desktop:h-20 h-12 aspect-square" src="{{$request->member->getProfileImage()}}" alt="{{$request->member->persistentUser->user->username}} profile picture">
        <div class="flex flex-col self-center ml-3 w-11/12">
            <h2 class="text-white"><a href="/members/{{$request->member->persistentUser->user->username}}">{{$request->member->persistentUser->user->username}}</a> has sent you a friend request.</h2>
            <h4 class="text-white">Do you wish to accept?</h4>
        </div>
        <div class="flex mobile:flex-row flex-col">
            <form class="self-center" id="accept-fr-form">
                <fieldset class="mobile:p-2 py-1">
                    <legend class="sr-only">Accept Friend Request</legend>
                    @csrf
                    <input type="hidden" id="accept-friend-request-id" value="{{$request->id}}">
                    <button class="button">&#10003;</button>
                </fieldset>
            </form>
            <form class="self-center" id="reject-fr-form">
                <fieldset class="mobile:p-2 py-1">
                    <legend class="sr-only">Reject Friend Request</legend>
                    @csrf
                    <input type="hidden" id="reject-friend-request-id" value="{{$request->id}}">
                    <button class="button">&#10005;</button>
                </fieldset>
            </form>
        </div>
    @endif
</article>