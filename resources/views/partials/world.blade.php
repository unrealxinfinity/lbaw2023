<article class="world md:w-2/3 peer-checked:fixed" data-id="{{ $world->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $world->id }}"> {{ $world->name }}</a></p>
    <header class="flex justify-start sm:h-40 h-24 m-5">
        <img class="pfp" src="https://source.unsplash.com/random/300x200">
        <div class="flex flex-col ml-5 pt-1">
        <h1><a href="/worlds/{{ $world->id }}">{{ $world->name }}</a></h1>
        <div class="flex"> <p class="tag"> placeholder </p> <p class="tag"> for tags </p>
        </div>
        <label for="show-details" class="md:hidden cursor-pointer text-medium sm:m-3 m-2 w-fit mt-5 underline text-grey"> see details </label>
    </header>
    <section id="search-project">@include('form.search-project', ['world' => $world])</section>
    <section id="projects">
    @if ($world->projects()->whereStatus('Active')->exists())
        <h2> ONGOING PROJECTS </h2>
        <ul class="panel">
            @foreach ($world->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
                <nav class="container">
                    <img class="h-1/2 overflow-hidden rounded-t-md" src="https://source.unsplash.com/random/300x200">
                    <div class="container-title"><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></div>
                    <div class="container-desc"><h4>{{ $project->name }}</h4></div>
                </nav>
            @endforeach
        </ul>
        @endif
        @if ($world->projects()->whereStatus('Archived')->exists())
        <h2> ARCHIVED PROJECTS </h2>
        <ul class="flex justify-start h-40 m-5">
            @foreach ($world->projects()->where('status', '=', 'Archived')->orderBy('id')->get() as $project)
                <nav class="box">
                    <h3><a href="/projects/{{ $project->id }}">{{ $project->name }}</a></h3>
                </nav>
            @endforeach
        </ul>
        @endif
    </section>
    @if (Auth::check() && Auth::user()->persistentUser->member->worlds->contains('id', $world->id) && Auth::user()->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin)
    @include('form.addmembertoworld', ['world' => $world])
    @endif
    <section id="comments">
        <h2> COMMENTS </h2>
        <ul>
            @each('partials.comment', $world->comments()->orderBy('id')->get(), 'comment')
        </ul>
        @if (Auth::check() && Auth::user()->persistentUser->member->worlds->contains('id', $world->id))
        @include('form.comment', ['route' => 'world-comment', 'id' => $world->id])
        @endif
    </section>
</article>
