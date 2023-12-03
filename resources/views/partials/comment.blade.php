<article id="comment" class="bg-grey border-solid border-green border-1 rounded py-3 px-5 my-5 mx-1 break-words overflow-clip text-mediumPhone md:text-medium" data-id = "{{ $comment->id }}">
    <header class="h-10 flex">
        <div class="grow-[1]">
            @include('partials.member', ['member' => $comment->member, 'main' => false])
        </div>
        <button type="button" class="show-edit">Edit</button>
        <p> {{ $comment->date_ }} </p>
    </header>
    <h4> {{ $comment->content }} </h4>
    <div class="comment-edit hidden">
        @include('form.edit-comment', ['comment' => $comment, 'type' => 'type'])
    </div>
</article>