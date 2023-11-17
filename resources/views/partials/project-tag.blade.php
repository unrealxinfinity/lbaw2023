<article class="projecttags">
    @foreach ($tags as $tag)
    <h2>{{ $tag->name }}</h2>
    @endforeach
</article>