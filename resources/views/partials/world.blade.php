<article class="world desktop:w-2/3 desktop:mr-5" data-id="{{ $world->id }}">
    <div class="flex justify-between">
        <p><a href="/">Home</a> > <a href="/worlds/{{ $world->id }}"> {{ $world->name }}</a></p>
        <h4><label for="show-details" class="desktop:hidden cursor-pointer text-opacity-50 outline outline-1 p-1 tablet:uppercase"> see details </label></h4>
    </div>
    <header class="flex justify-between mobile:h-28 tablet:h-32 desktop:h-40 h-20 tablet:my-5 my-2 ml-1">
        <div class="flex justify-start">
            <img class="h-full aspect-square object-cover" src={{ $world->getImage() }} alt="{{$world->name}} image">
            <div class="flex flex-col tablet:ml-5 mobile:ml-2 ml-1 pt-1">
                <div class="flex">
                <h1>{{ $world->name }}</h1>
                @can('edit', $world)
                    <h1><a id="edit-world" class="mt-2 tablet:ml-2 ml-1 hover:text-green" href="/worlds/{{ $world->id }}/edit" title="Edit World">&#9998;</a></h1>
                @endcan
                </div>
                @include('partials.tag', ['tags' => $world->tags,'type'=>'world'])
            </div>
        </div>
        <div class="relative flex text-left pt-1">
            @can('favorite', $world)
                <form id="favorite">
                    <fieldset>
                        <legend class="sr-only">Set World as Favorite</legend>
                        @csrf
                        <input type="hidden" class="id" name="id" value="{{ $world->id }}">
                        <input type="hidden" class="type" name="type" value="worlds">
                        @if(Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator') && Auth::user()->persistentUser->member->favoriteWorld->contains('id', $world->id))
                            <h1><button class="pr-2" type="submit" title="Remove from Favorites"> &#9733; </button></h1>
                        @elseif((Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator'))) 
                            <h1><button class="pr-2" type="submit" title="Add to Favorites"> &#9734; </button></h1> 
                        @endif
                    </fieldset>
                </form>
            @endcan
            @canany(['leave','delete'], $world)
                <input type="checkbox" id="more-options" class="sr-only sr-only-focusable peer"/>
                <h1><label for="more-options" class="font-bold cursor-pointer sr-only-focusable" title="More Options">&#8942;</label></h1>
                <div class="absolute right-0 px-1 z-10 mr-2 desktop:mt-7 tablet:mt-6 mt-5 min-w-max bg-black outline outline-1 outline-white/20 peer-checked:block hidden divide-y divide-white divide-opacity-25">
                    @can('delete', $world)
                    @include('form.delete-world', ['world' => $world])
                    @endcan
                    @can('leave', $world)
                    <form method="POST" class="leave-world" action={{ route('leave-world', ['id' => $world->id, 'username' => Auth::user()->username]) }}>
                        <fieldset>
                            <legend class="sr-only">Leave World</legend>
                            @CSRF
                            @method('DELETE')
                            <h3><button class="px-3 py-1 w-full" type="submit">Leave World</button></h3>
                        </fieldset>
                    </form>
                    @endcan
                </div>
            @endcanany
        </div>
    </header>
    <section id="search-project">@include('form.search-project', ['world' => $world])</section>
    <section id="projects">
    @if ($world->projects()->whereStatus('Active')->exists())
        <h2 class="mt-10" id="Ongoing-projects"> ONGOING PROJECTS </h2>
        <ul class="panel">
            @foreach ($world->projects()->where('status', '=', 'Active')->orderBy('id')->get() as $project)
                <nav class="container">
                    <img class="h-1/2 overflow-hidden rounded-t-md object-cover" src={{ $project->getImage() }} alt="{{$project->name}} image">
                    @php
                        $translateXValue = (strlen($project->name)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
                    @endphp
                    <div class="title"><h2><a class="{{$translateXValue}}" href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2></div>
                    <div class="desc"><h4>{{ $project->description }}</h4></div>
                </nav>
            @endforeach
        </ul>
        @endif
        @if ($world->projects()->whereStatus('Archived')->exists())
        <h2 class="mt-10" id="Archived-projects"> ARCHIVED PROJECTS </h2>
        <ul class="flex justify-start h-40 m-5">
            @foreach ($world->projects()->where('status', '=', 'Archived')->orderBy('id')->get() as $project)
            <nav class="container">
                <img class="h-1/2 overflow-hidden rounded-t-md object-cover" src={{ $project->getImage() }} alt="{{$project->name}} image">
                @php
                    $translateXValue = (strlen($project->name)>20)? 'hover:translate-x-[-40%]': 'hover:translate-x-[0%]';
                @endphp
                <div class="title"><h2><a class="{{$translateXValue}}" href="/projects/{{ $project->id }}">{{ $project->name }}</a></h2></div>
                <div class="desc"><h4>{{ $project->description }}</h4></div>
            </nav>
            @endforeach
        </ul>
        @endif
    </section>
    @can('edit', $world)
        <span id="invite-member-to-world"></span>
        @include('form.addmembertoworld', ['world' => $world])
        <span id="create-new-project"></span>
        @include('form.project-create', ['world'=>$world])
    @endcan
    @can('worldTagCreate', $world)
        <span id="create-world-tag"></span>
        @include('form.tag-create',['world'=> $world,'type' => 'world'])
    @endcan
    <section id="comments">
        <h2 class="mt-10"> COMMENTS </h2>
        <ul>
            @foreach ($world->comments()->orderBy('id')->get() as $comment)
                @include('partials.comment', ['comment' => $comment, 'type' => 'world'])
            @endforeach
        </ul>
        @if (Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator') && Auth::user()->persistentUser->member->worlds->contains('id', $world->id))
        <span id="make-world-comment"></span>
        @include('form.comment', ['route' => 'world-comment', 'id' => $world->id, 'type' => 'world'])
        @endif
    </section>
</article>
