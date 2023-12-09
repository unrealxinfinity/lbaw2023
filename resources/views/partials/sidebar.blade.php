<article id="sidebar" class="desktop:w-1/3 desktop:mt-8 mt-20 desktop:ml-5 mr-3">
    <label for="show-details" class="desktop:hidden cursor-pointer m-2">&times;</label>
    <h2> Description </h2>
    <p class="mt-3 mb-5 desktop:w-11/12">{{ $thing->description }}</p>
    <h2>Members</h2>
    <ul class="members mr-5 ml-2 mt-2">
        @if ($type == 'project')
        <div id="project-leaders">
            <h3 class="text-green mb-1"> Project Leaders </h3>
            @foreach($thing->members()->where('permission_level', '=', 'Project Leader')->orderBy('id')->get() as $member)
                <div class="grid grid-cols-2">
                    @include('partials.member', ['member' => $member, 'main' => false])
                    @can('removeLeader', $thing)
                        @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                    @endcan
                </div>
            @endforeach
        </div>
        <div id="members">
            <h3 class="text-green mb-1"> Members </h3>
            @foreach($thing->members()->where('permission_level', '=', 'Member')->orderBy('id')->get() as $member)
                <div class="grid grid-cols-2">
                    @include('partials.member', ['member' => $member, 'main' => false])
                    @can('removeMember', $thing)
                        @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                    @endcan
                </div>
            @endforeach
        </div>
        @endif
        @if ($type == 'world')
            <h3 class="text-green mb-1"> World Owner </h3>
                @include('partials.member', ['member' => $thing->owner()->get()->first(), 'main' => false])
            <div id="world-admins">
                <h3 class="text-green mb-1"> World Admins </h3>
                @foreach($thing->members()->where('is_admin', '=', 'true')->orderBy('id')->get() as $member)
                    <div class="grid grid-cols-2">
                        @if ($member->id != $thing->owner()->get()->first()->id)
                            @include('partials.member', ['member' => $member, 'main' => false])
                            @can('removeAdmin', $thing)
                                @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                            @endcan
                        @endif
                    </div>
                @endforeach
            </div>
            <div id="members">
                <h3 class="text-green mb-1"> Members </h3>
                @foreach($thing->members()->where('is_admin', '=', 'false')->orderBy('id')->get() as $member)
                    <div class="grid grid-cols-2">
                        @include('partials.member', ['member' => $member, 'main' => false])
                        @can('removeMember', $thing)
                            @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                        @endcan
                    </div>
                @endforeach
            </div>
        @endif
    </ul>
</article>