<article>
    <div class="flex">
        <img class="h-16 aspect-square mt-5 ml-5 ">
        <div class="flex flex-col">
            <h1 class="text-white">You have been invited to join <a href="worlds/{{$invite->world_id}}">{{$invite->world_id}}</a></h1>
            <h3 class="text-white">Do you wish to join?</h2>
            <div class="flex justify-around w-full max-w-4xl">
                <form class="form-post w-1/2 px-4" action={{ route ('join-world', ['id' => $invite->world_id]) }} method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" class="token" name="token" value="{{ $invite->token }}">
                    <input type="hidden" class="acceptance" name="acceptance" value=1>
                    <input class="button" type="submit" value="Yes">
                </form>
                <form class="form-post w-1/2 px-4" action={{ route ('join-world', ['id' => $invite->world_id]) }} method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" class="token" name="token" value="{{ $invite->token }}">
                    <input type="hidden" class="acceptance" name="acceptance" value=0>
                    <input class="button" type="submit" value="No">
                </form>
            </div>
        </div>
    </div>
</article>