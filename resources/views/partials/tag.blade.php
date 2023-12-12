
@if($type == 'project')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <div class="tag flex">
        <p>{{ $tag->name }}</p>
        @can('deleteProjectTag', $project)
            @include('form.tag-delete', ['project' => $project, 'tag' => $tag, 'type' => 'project'])
        @endcan
    </div>
    @endforeach
</div>
@endif
@if($type == 'world')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <div class="tag flex">
        <p>{{ $tag->name }}</p>
        @can('deleteWorldTag', $world)
            @include('form.tag-delete', ['world' => $world, 'tag' => $tag, 'type' => 'world'])
        @endcan
    </div>
    @endforeach
</div>
@endif
@if($type == 'member')
<div class="tagList flex flex-wrap overflow-hidden">
    @foreach ($tags as $tag)
    <div class="tag flex">
        <p>{{ $tag->name }}</p>
        @can('deleteMemberTag', $member)
            @include('form.tag-delete', ['member' => $member, 'tag' => $tag, 'type' => 'member'])
        @endcan
    </div>
    @endforeach
</div>
@endif