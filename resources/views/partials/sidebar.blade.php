<article class="md:w-1/3 mt-8">
    <label for="show-details" class="md:hidden cursor-pointer md:text-big text-bigPhone sm:m-3 m-2 w-fit">&times;</label>
    <h1> Description </h1>
    <p>{{ $thing->description }}</p>
    <h1>Members</h1>
    <ul class="members mr-5">
        @if ($type == 'project')
        <div id="project-leaders">
            <h2 class="text-grey font-semibold"> Project Leaders </h2>
            @foreach($thing->members()->where('permission_level', '=', 'Project Leader')->orderBy('id')->get() as $member)
                <div class="flex justify-between">
                    @include('partials.member', ['member' => $member, 'main' => false])
                    @can('removeLeader',$thing)   
                        @cannot('assignOwn',$member)
                            @include('form.assign-project-leader', ['project' => $thing, 'member' => $member,'isPromote'=>false])
                        @endcannot
                    @endcan
                    @can('removeMember', $thing)
                        @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                    @endcan
                </div>
            @endforeach
        </div>
        <div id="members">
            <h2 class="mt-5 text-grey font-semibold"> Members </h2>
            @foreach($thing->members()->where('permission_level', '=', 'Member')->orderBy('id')->get() as $member)
                <div class="flex justify-between">
                    @include('partials.member', ['member' => $member, 'main' => false])
                    @can('removeMember', $thing)
                        
                            
                        @cannot('assignOwn', $member)
                            @include('form.assign-project-leader', ['project' => $thing, 'member' => $member,'isPromote'=>true])
                        @endcannot
                        @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                    @endcan
                </div>
            @endforeach
        </div>
        @endif
        @if ($type == 'world')
            <h2 class="text-grey font-semibold"> World Owner </h2>
                @include('partials.member', ['member' => $thing->owner()->get()->first(), 'main' => false])
            <div id="world-admins">
                <h2 class="mt-5 text-grey font-semibold"> World Admins </h2>
                @foreach($thing->members()->where('is_admin', '=', 'true')->orderBy('id')->get() as $member)
                    
                    <div class="flex justify-between">
                        
                        @if ($member->id != $thing->owner()->get()->first()->id)
                            @include('partials.member', ['member' => $member, 'main' => false])
                            @can('removeAdmin', $thing)
                                @cannot('assignOwn',$member)
                                    @include('form.assign-admin-to-world', ['world' => $thing, 'member' => $member,'isAdmin'=> true])
                                @endcannot
                                @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                            @endcan
                        @endif
                    </div>
                @endforeach
            </div>
            <div id="members">
                <h2 class="mt-5 text-grey font-semibold"> Members </h2>
                @foreach($thing->members()->where('is_admin', '=', 'false')->orderBy('id')->get() as $member)
               
                    <div class="flex justify-between">
                        @include('partials.member', ['member' => $member, 'main' => false])
                        @can('removeMember', $thing)
                            @cannot('assignOwn',$member)
                                @include('form.assign-admin-to-world', ['world' => $thing, 'member' => $member,'isAdmin'=> false])
                            @endcannot
                            @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                        @endcan
                    </div>
                @endforeach
            </div>
        @endif
    </ul>
</article>