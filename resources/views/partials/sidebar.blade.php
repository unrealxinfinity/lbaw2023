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
            <div class="flex mb-1 items-center">
                <h3 class="text-green"> World Owner </h3>
                @can('transfer', $thing)
                    <h2 class="ml-2 font-extrabold"><a href="/worlds/{{ $world->id }}/transfer">&#x2942;</a></h2>
                @endcan
            </div>
                @include('partials.member', ['member' => $thing->owner()->get()->first(), 'main' => false])
            <div id="world-admins">
                <h3 class="text-green mb-1 mt-4"> World Admins </h3>
                @foreach($thing->members()->where('is_admin', '=', 'true')->orderBy('id')->get() as $member)
                    @if ($member->id != $thing->owner()->get()->first()->id)
                        <div class="h-5 flex items-center justify-between">
                            @include('partials.member', ['member' => $member, 'main' => false])
                            @can('removeAdmin', $thing)
                                <div class="flex items-center child:mx-1">
                                    @include('form.assign-admin-to-world', ['world' => $thing, 'member' => $member,'isAdmin'=> true])
                                    @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                                </div>
                            @endcan
                        </div>
                    @endif
                @endforeach
            </div>
            <div id="members">
                <h3 class="text-green mb-1 mt-4"> Members </h3>
                @foreach($thing->members()->where('is_admin', '=', 'false')->orderBy('id')->get() as $member)
                    <div class="h-5 flex items-center justify-between">
                        @include('partials.member', ['member' => $member, 'main' => false])
                        @can('removeMember', $thing)
                            <div class="flex items-center child:mx-1">
                                @include('form.assign-admin-to-world', ['world' => $thing, 'member' => $member,'isAdmin'=> false])
                                @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                            </div>
                        @endcan
                    </div>
                @endforeach
            </div>
        @endif
    </ul>
</article>