<article id="comment" class="outline outline-1 outline-white/20 bg-black bg-opacity-80 p-3 my-3 break-words overflow-clip rounded" data-id = "{{ $comment->id }}">
    <header class="h-10 flex">
        <div class="grow-[1] pt-0.5">
            @include('partials.member', ['member' => $comment->member, 'main' => false])
        </div>
        @if (Auth::check() && Auth::user()->persistentUser->member->id == $comment->member_id)
            <h3><button type="button" class="show-edit mobile:mr-3 mr-1 py-0.5 px-1.5 rounded-full outline outline-1 outline-white/20">Edit</button></h3>
        @endif
        <p class="pt-1"> {{ $comment->date_ }} </p>
    </header>
    <h4 class="comment-content"> {{ $comment->content }} </h4>
    <div class="comment-edit hidden">
        @include('form.edit-comment', ['comment' => $comment, 'type' => $type])
    </div>
</article>