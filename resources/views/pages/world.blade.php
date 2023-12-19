@extends('layouts.app')

@section('title', $world->name)

@section('content')
    <a href="#search-project" class="sr-only sr-only-focusable">Jump to Search Projects inside this World</a>
    <a href="#Ongoing-projects" class="sr-only sr-only-focusable">Jump to Ongoing Projects</a>
    @if ($world->projects()->whereStatus('Archived')->exists())
        <a href="#Archived-projects" class="sr-only sr-only-focusable">Jump to Archived Projects</a>
    @endif
    
    @can('worldTagCreate', $world)
        <a href="#create-world-tag" class="sr-only sr-only-focusable">Jump to Create a Tag</a>
    @endcan
    <a href="#comments" class="sr-only sr-only-focusable">Jump to Comments</a>
    @if (Auth::check() && (Auth::user()->persistentUser->type_ !== 'Administrator') && Auth::user()->persistentUser->member->worlds->contains('id', $world->id))
        <a href="#make-world-comment" class="sr-only sr-only-focusable">Jump to Make a Comment</a>
    @endif

    <a href="#see-members" class="sr-only sr-only-focusable">Jump to Members</a>

    @can('edit', $world)
        <a href="#edit-world" class="sr-only sr-only-focusable">Jump to Edit World</a>
        <a href="#invite-member-to-world" class="sr-only sr-only-focusable">Jump to Invite Members</a>
        <a href="#create-new-project" class="sr-only sr-only-focusable">Jump to Create a Project</a>
    @endcan
    @can('favorite', $world)
        <a href="#favorite" class="sr-only sr-only-focusable">Jump to Favorite World</a>
    @endcan
    @canany(['leave','delete'], $world)
        <a href="#more-options" class="sr-only sr-only-focusable">Jump to More Options</a>
    @endcanany


    <section id="worlds" class="desktop:flex">
        <input type="checkbox" id="show-details" class="hidden peer"/>
        @include('partials.world', ['world' => $world])
        <div class="desktop:hidden fixed bg-opacity-95 bg-black top-0 h-full w-0 right-0 mobile:peer-checked:w-2/3 tablet:peer-checked:w-1/2 peer-checked:w-full peer-checked:px-5 transition-width duration-500 z-10">
            @include('partials.sidebar', ['thing'=>$world, 'type' => 'world'])
        </div>
        <div class="hidden desktop:contents">
            @include('partials.sidebar', ['thing'=>$world, 'type' => 'world'])
        </div>
    </section>
    @if ($subform)
    <script>
        document.body.style.overflow = 'hidden';
    </script>
    <div id="edit-world" class="fixed z-30 bg-white bg-opacity-30 top-0 left-0 w-full h-full flex flex-col justify-around">
        <div class="bg-black tablet:w-3/4 tablet:min-h-fit tablet:max-h-[90%] h-full w-full tablet:rounded tablet:mx-auto">
            <div class="flex justify-between mx-5 pt-3">
            <h1> {{ $formTitle }} </h1>
            <h1><a id="go-back" class="cursor-pointer">&times;</a></h1>
            </div>
            <div class="overflow-auto tablet:min-h-fit tablet:max-h-[90%] h-[90%]">
            @include($formName, ['world'=>$world])
            </div>
        </div>
    </div>
    @endif
@endsection