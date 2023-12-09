<article class="mytask h-fit self-center p-3 mx-1 my-4 bg-black outline outline-1 outline-white/20 rounded" data-id="{{ $task->id }}">
    <h2 class="break-words"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
    <h4 class="break-words"> {{ $task->description }} </h4>
</article>