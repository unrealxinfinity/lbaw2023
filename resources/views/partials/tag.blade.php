<ul>
    @foreach ($tags as $tag)
    <span class="badge badge-secondary">{{ $tag->name }}</span>
    @endforeach
</ul>
