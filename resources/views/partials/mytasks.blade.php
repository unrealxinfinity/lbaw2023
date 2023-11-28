<article class="mytask bg-grey rounded m-5" data-id="{{ $task->id }}">
        <div class="flex flex-col">
            <h1 class="text-white"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></h2>
            <h2 class="ml-3 mb-5"> {{ $task->description }} </h4>
        </div>
</article>