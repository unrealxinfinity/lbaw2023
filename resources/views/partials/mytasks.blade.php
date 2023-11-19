<article class="mytask" data-id="{{ $task->id }}">
    <div class="row">
        <div class="column">
            <h2><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
            <h4> {{ $task->description }} </h4>
        </div>
    </div>
</article>