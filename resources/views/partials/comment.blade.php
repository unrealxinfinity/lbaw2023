<article id="comment" class="bg-grey border-solid border-green border-1 rounded py-3 px-5 my-5 mx-1 break-words overflow-clip text-mediumPhone sm:text-medium" data-id = "{{ $comment->id }}">
    <header class="h-10 flex justify-between">
        @include('partials.member', ['member' => $comment->member, 'main' => false])
        <p> {{ $comment->date_ }}
    </header>
    <h4> {{ $comment->content }} </h4>
</article>