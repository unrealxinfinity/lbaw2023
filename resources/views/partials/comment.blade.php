<article class="comment" data-id = "{{ $comment->id }}">
    <header>
        @if($comment->member != NULL)
        @include('partials.member', ['member' => $comment->member, 'main' => false])
        @else
        <h4> Guest </h4>
        @endif
        <p> {{ $comment->date_ }}
    </header>
    <h4> {{ $comment->content }} </h4>
</article>