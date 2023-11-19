<article class="myproject" data-id="{{ $project->id }}">
    <div class="row">
        <img src={{$project->picture}} class="big">
        <div class="column">
            <h2><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2>
            <h4> {{ $project->description }} </h4>
        </div>
    </div>
</article>