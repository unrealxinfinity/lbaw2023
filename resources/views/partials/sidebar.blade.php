<article class="md:w-1/3 mt-8">
    <label for="show-details" class="md:hidden cursor-pointer sm:text-big text-bigPhone sm:m-3 m-2 w-fit">&times;</label>
    <h1> Description </h1>
    <p>{{ $thing->description }}</p>
    <h1>Members</h1>
    <ul class="members">
        @if ($type == 'project')
        <h2 class="text-grey"> Project Leaders </h2>
        @foreach($thing->members()->where('permission_level', '=', 'Project Leader')->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
            @include('form.remove-member', ['thing' => $thing, 'member' => $member])
        @endforeach
        <h2 class="mt-5 text-grey"> Members </h2>
        @foreach($thing->members()->where('permission_level', '=', 'Member')->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
        @endif
        @if ($type == 'world')
        <h2 class="text-grey"> World Owner </h2>
            @include('partials.member', ['member' => $thing->owner()->get()->first(), 'main' => false])
        <h2 class="mt-5 text-grey"> World Admins </h2>
        @foreach($thing->members()->where('is_admin', '=', 'true')->orderBy('id')->get() as $member)
            @if ($member->id != $thing->owner()->get()->first()->id)
            @include('partials.member', ['member' => $member, 'main' => false])
            @endif
        @endforeach
        <h2 class="mt-5 text-grey"> Members </h2>
        @foreach($thing->members()->where('is_admin', '=', 'false')->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
        @endif
    </ul>
    @if(Auth::check() && Auth::user()->persistentUser->member->worlds->contains('id', $thing->id) && $thing->owner_id != Auth::user()->persistentUser->member->id)
        @include ('form.leave-thing', ['thing' => $thing])
    @elseif(Auth::check() && Auth::user()->persistentUser->member->projects->contains('id', $thing->id))
        @include ('form.leave-thing', ['thing' => $thing])
    @endif
</article>