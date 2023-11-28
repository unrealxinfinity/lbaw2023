<article class="md:w-1/3 mt-8">
    <label for="show-details" class="md:hidden cursor-pointer sm:text-big text-bigPhone sm:m-3 m-2 w-fit">&times;</label>
    <h1> Description </h1>
    <p>{{ $thing->description }}</p>
    <h1>Members</h1>
    <ul class="members">
        @foreach($thing->members()->orderBy('id')->get() as $member)
            @include('partials.member', ['member' => $member, 'main' => false])
        @endforeach
    </ul>
    @if(Auth::check() && Auth::user()->persistentUser->member->worlds->contains('id', $thing->id) && $thing->owner_id != Auth::user()->persistentUser->member->id)
        @include ('form.leave-thing', ['thing' => $thing])
    @elseif(Auth::check() && Auth::user()->persistentUser->member->projects->contains('id', $thing->id))
        @include ('form.leave-thing', ['thing' => $thing])
    @endif
</article>