<article class="homepage" data-id="{{ $member->id }}">
        <h3> My Assigned Tasks </h3>
        <div class="row">
        @foreach($member->tasks()->orderBy('id')->get() as $task)
        <div class="box"> 
            <h3><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h3>
        </div>
        @endforeach
        </div>
</article>
