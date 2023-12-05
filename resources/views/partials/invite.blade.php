<article class="invite flex flex-col justify-center items-center space-y-4">
    <h1>You have been invited to join <a href="/worlds/{{$world_id}}" class="underline">{{$world_name}}</a></h1>
    <h3 class="text-white">Do you wish to join?</h2>
    <div class="flex justify-around w-full max-w-4xl">
        <form class="form-post w-1/2 px-4" action={{ route ('join-world', ['id' => $world_id]) }} method="POST">
            @csrf
            @method('POST')
            <input type="hidden" class="token" name="token" value="{{ $token }}">
            <input type="hidden" class="world_id" name="world_id" value="{{ $world_id }}">
            <input type="hidden" class="username" name="username" value="{{ $username }}">
            <input type="hidden" class="type" name="type" value="{{ $type }}">
            <input type="hidden" class="acceptance" name="acceptance" value="true">
            <input class="button" type="submit" value="Yes">
        </form>
        <form class="form-post w-1/2 px-4" action={{ route ('join-world', ['id' => $world_id]) }} method="POST">
            @csrf
            @method('POST')
            <input type="hidden" class="token" name="token" value="{{ $token }}">
            <input type="hidden" class="world_id" name="world_id" value="{{ $world_id }}">
            <input type="hidden" class="username" name="username" value="{{ $username }}">
            <input type="hidden" class="type" name="type" value="{{ $type }}">
            <input type="hidden" class="acceptance" name="acceptance" value="false">
            <input class="button" type="submit" value="No">
        </form>
    </div>
</article>