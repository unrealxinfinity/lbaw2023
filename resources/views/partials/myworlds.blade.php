<article class="myworld" data-id="{{ $world->id }}">
    <header>
        <div class="row">
            <img src={{$world->picture}} class="big">
            <div class="column">
                <h2><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h2>
                <h4> {{ $world->description }} </h4>
            </div>
        </div>
    </header>
</article>