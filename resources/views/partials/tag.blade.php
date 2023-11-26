<div class="flex">
    @foreach ($tags as $tag)
    <p class="tag">{{ $tag->name }}</p>
    @endforeach
</div>
