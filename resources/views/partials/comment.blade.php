<article class="comment" data-id = "{{ $comment->id }}">
    <header>
        @include('partials.member', ['member' => $comment->member, 'main' => false])
        <p> {{ $comment->date_ }}
    </header>
    <h4> {{ $comment->content }} </h4>
</article>