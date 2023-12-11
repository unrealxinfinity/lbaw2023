
@if($type == 'project')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <p class="tag">{{ $tag->name }}</p>
    @endforeach
</div>
@endif
@if($type == 'world')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <p class="tag">{{ $tag->name }}</p>
    @endforeach
</div>
@endif