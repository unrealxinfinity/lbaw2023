@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<article class="project">
    <form action="{{ route('create-project') }}" id="new-project" method="POST">Create a New Project!!
        @csrf
        @method('POST')

        <input type="hidden" name="world_id" value="{{ $world->id }}">
        <input type="text" name="name" placeholder="New Project Name">
        @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
        </span>
        @endif
        <input type="text" name="description" placeholder="Description">
        @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
        @endif

        <button type="submit">Create</button>

    </form>
</article>
@endsection