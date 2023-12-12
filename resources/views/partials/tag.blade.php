
@if($type == 'project')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <p class="tag">{{ $tag->name }}</p>
        @can('deleteProjectTag', $project)
            @include('form.tag-delete', ['project' => $project, 'tag' => $tag, 'type' => 'project'])
        @endcan
    @endforeach
</div>
@endif
@if($type == 'world')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <p class="tag">{{ $tag->name }}</p>
        @can('deleteWorldTag', $world)
            @include('form.tag-delete', ['world' => $world, 'tag' => $tag, 'type' => 'world'])
        @endcan
    @endforeach
</div>
@endif
@if($type == 'member')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <p class="tag">{{ $tag->name }}</p>
    @can('deleteMemberTag', $member)
            @include('form.tag-delete', ['member' => $member, 'tag' => $tag, 'type' => 'member'])
        @endcan
    @endforeach
</div>
@endif