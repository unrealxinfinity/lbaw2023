<article id="{{$prefix . 'sidebar'}}" class="desktop:w-1/3 desktop:mt-8 mt-20 desktop:ml-5 mr-3">
    <label for="show-details" class="desktop:hidden cursor-pointer m-2">&times;</label>
    <h2> Description </h2>
    <p class="mt-3 mb-5 desktop:w-11/12">{{ $thing->description }}</p>
    <h2 id="{{$prefix . 'see-members'}}">Members</h2>
    <ul class="membersof mr-5 ml-2 mt-2">
        @if ($type == 'project')
        <h3 class="decoration-green underline underline-offset-4 decoration-2 mb-1"> Project Leaders </h3>
        <ul id="{{$prefix . 'project-leaders'}}" class="project-leaders">  
            @foreach($thing->members()->where('permission_level', '=', 'Project Leader')->orderBy('id')->get() as $member)
                <li class="h-5 flex items-center justify-between">
                    @include('partials.member', ['member' => $member, 'main' => false])
                    @cannot('assignOwn',$member)
                        <div class="flex items-center child:mx-1">
                            @can('AssignProjectLeader',$thing)
                                @include('form.assign-project-leader', ['project' => $thing, 'member' => $member,'isPromote'=>false])
                            @endcan
                            @can('removeLeader',$thing) 
                                @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                            @endcan
                        </div>
                    @endcannot
                </li>
            @endforeach
        </ul>
        <h3 class="decoration-green underline underline-offset-4 decoration-2 mb-1 mt-4"> Members </h3>
        <ul id="{{$prefix . 'members'}}" class="members">
            @foreach($thing->members()->where('permission_level', '=', 'Member')->orderBy('id')->get() as $member)
                <li class="h-5 flex items-center justify-between">
                    @include('partials.member', ['member' => $member, 'main' => false])
                        @cannot('assignOwn', $member)
                        <div class="flex items-center child:mx-1">
                            @can('AssignProjectLeader',$thing)
                                @include('form.assign-project-leader', ['project' => $thing, 'member' => $member,'isPromote'=>true])
                            @endcan
                            @can('removeMember', $thing)
                                @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                            @endcan
                        @endcannot
                </li>
            @endforeach
        </ul>
        @endif
        @if ($type == 'world')
            <div class="flex mb-1 items-center">
                <h3 class="decoration-green underline underline-offset-4 decoration-2"> World Owner </h3>
                @can('transfer', $thing)
                    <h2 class="ml-2 font-bold cursor-pointer"><a href="/worlds/{{ $world->id }}/transfer" title="Transfer Ownership" aria-label="Transfer Ownership">&#x2942;</a></h2>
                @endcan
            </div>
                @include('partials.member', ['member' => $thing->owner()->get()->first(), 'main' => false])
            <h3 class="decoration-green underline underline-offset-4 decoration-2 mb-1 mt-4"> World Admins </h3>
            <ul id="{{$prefix . 'world-admins'}}">    
                @foreach($thing->members()->where('is_admin', '=', 'true')->orderBy('id')->get() as $member)
                    @if ($member->id != $thing->owner()->get()->first()->id)
                        <li class="h-5 flex items-center justify-between">
                            @include('partials.member', ['member' => $member, 'main' => false])
                            @cannot('assignOwn',$member)
                                <div class="flex items-center child:mx-1">
                                    @can('assignWorldAdmin', $thing)
                                        @include('form.assign-admin-to-world', ['world' => $thing, 'member' => $member,'isAdmin'=> true])
                                    @endcan
                                    @can('removeAdmin', $thing)
                                        @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                                    @endcan
                                </div>
                            @endcannot
                        </li>
                    @endif
                @endforeach
            </ul>
            <h3 class="decoration-green underline underline-offset-4 decoration-2 mb-1 mt-4"> Members </h3>
            <ul id="{{$prefix . 'members'}}">
                @foreach($thing->members()->where('is_admin', '=', 'false')->orderBy('id')->get() as $member)
                    <li class="h-5 flex items-center justify-between">
                        @include('partials.member', ['member' => $member, 'main' => false])
                        @cannot('assignOwn',$member)
                            <div class="flex items-center child:mx-1">
                                @can('assignWorldAdmin', $thing)
                                    @include('form.assign-admin-to-world', ['world' => $thing, 'member' => $member,'isAdmin'=> false])
                                @endcan
                                @can('removeMember', $thing)
                                    @include('form.remove-member', ['thing' => $thing, 'member' => $member])
                                @endcan
                            </div>
                        @endcannot
                    </li>
                @endforeach
            </ul>
        @endif
    </ul>
</article>