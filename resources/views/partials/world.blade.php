<article class="world md:w-2/3 peer-checked:fixed" data-id="{{ $world->id }}">
    <p><a href="/">Home</a> > <a href="/worlds/{{ $world->id }}"> {{ $world->name }}</a></p>
    <header class="flex justify-between sm:h-40 h-24 m-5">
        <div class="flex justify-start">
            <img class="h-full aspect-square " src={{ $world->getImage() }}>
            <div class="flex flex-col ml-5 pt-1">
                <div class="flex">
                <h1>{{ $world->name }}</h1>
                @can('edit', $world)
                    <a class="mt-2 ml-1 text-bigPhone md:text-big hover:text-green" href="/worlds/{{ $world->id }}/edit">&#9998;</a>
                @endcan
                </div>
            <div class="flex"> <p class="tag"> placeholder </p> <p class="tag"> for tags </p>
            </div>
            <label for="show-details" class="md:hidden cursor-pointer text-mediumPhone sm:m-3 m-2 w-fit mt-5 underline text-grey"> see details </label>
        </div>
        </div>
        @if(Auth::check() && (Auth::user()->can('leave', $world) || Auth::user()->can('delete', $world)))
        <div class="relative inline-block text-left">
            <input type="checkbox" id="more-options" class="hidden peer"/>
            <label for="more-options" class="text-start font-bold md:text-big text-bigPhone h-fit my-3 sm:mr-5 cursor-pointer">&#8942;</label>
            <div class="absolute right-0 z-10 w-40 sm:mr-5 px-2 rounded bg-grey peer-checked:block hidden divide-y divide-white divide-opacity-25">
                @if(Auth::check() && Auth::user()->can('delete', $world))
                @include('form.delete-world', ['world' => $world])
                @endif
                @if(Auth::check() && Auth::user()->can('leave', $world))
                <form method="POST" action={{ route('leave-world', ['id' => $world->id, 'username' => Auth::user()->username]) }}>
                    @CSRF
                    @method('DELETE')
                    <button class="px-3 py-1 w-full md:text-medium text-mediumPhone" type="submit">Leave World</button>
                </form>
                @endif
            </div>
            
        </div>
        @endif
    </header>
    <section id="search-project">@include('form.search-project', ['world' => $world])</section>
    <section id="projects">
    @if ($world->projects()->whereStatus('Active')->exists())
        <h2 class="mt-10"> ONGOING PROJECTS </h2>
        <ul class="panel">
            @foreach ($world->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
                <nav class="container">
                    <img class="h-1/2 overflow-hidden rounded-t-md " src={{ $project->getImage() }}>
                    @php
                        $translateXValue = (strlen($project->name)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
                    @endphp
                    <div class="title"><a class="{{$translateXValue}}" href="/projects/{{ $project->id }}">{{ $project->name }}</a></div>
                    <div class="desc"><h4>{{ $project->name }}</h4></div>
                </nav>
            @endforeach
        </ul>
        @endif
        @if ($world->projects()->whereStatus('Archived')->exists())
        <h2 class="mt-10"> ARCHIVED PROJECTS </h2>
        <ul class="flex justify-start h-40 m-5">
            @foreach ($world->projects()->where('status', '=', 'Archived')->orderBy('id')->get() as $project)
            <nav class="container">
                <img class="h-1/2 overflow-hidden rounded-t-md " src={{ $project->getImage() }}>
                @php
                    $translateXValue = (strlen($project->name)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
                @endphp
                <div class="title"><a class="{{$translateXValue}}" href="/projects/{{ $project->id }}">{{ $project->name }}</a></div>
                <div class="desc"><h4>{{ $project->name }}</h4></div>
            </nav>
            @endforeach
        </ul>
        @endif
    </section>
    @if (Auth::check() && Auth::user()->can('edit', $world))
    @include('form.addmembertoworld', ['world' => $world])
    @include('form.project-create', ['world'=>$world])
    @endif
    <section id="comments">
        <h2 class="mt-10"> COMMENTS </h2>
        <ul>
            @foreach ($world->comments()->orderBy('id')->get() as $comment)
                @include('partials.comment', ['comment' => $comment, 'type' => 'world'])
            @endforeach
        </ul>
        @if (Auth::check() && Auth::user()->persistentUser->member->worlds->contains('id', $world->id))
        @include('form.comment', ['route' => 'world-comment', 'id' => $world->id, 'type' => 'world'])
        @endif
    </section>
</article>
