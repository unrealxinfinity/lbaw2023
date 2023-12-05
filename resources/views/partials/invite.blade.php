<article class="invite">

    <h1>You have been invited to join <a href="/worlds/{{$world_id}}">{{$world_name}}</a></h1>
    <h2>Do you wish to join?</h2>
    <form class="form-post" action={{ route ('join-world', ['id' => $world_id]) }} method="POST">
        @csrf
        @method('POST')
        <input type="hidden" class="world_id" name="world_id" value="{{ $world_id }}">
        <input type="hidden" class="username" name="username" value="{{ $username }}">
        <input type="hidden" class="type" name="type" value="{{ $type }}">
        <input type="hidden" class="acceptance" name="acceptance" value="true">
        <input class="button" type="submit" value="Yes">
    </form>
    <form class="form-post" action={{ route ('join-world', ['id' => $world_id]) }} method="POST">
        @csrf
        @method('POST')
        <input type="hidden" class="world_id" name="world_id" value="{{ $world_id }}">
        <input type="hidden" class="username" name="username" value="{{ $username }}">
        <input type="hidden" class="type" name="type" value="{{ $type }}">
        <input type="hidden" class="acceptance" name="acceptance" value="false">
        <input class="button" type="submit" value="No">
    </form>

</article>