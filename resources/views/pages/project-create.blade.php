@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<article class="project">
  <p><a href="/">Home</a> > <a href="/worlds/{{ $world->id }}"> {{ $world->name }}</a> > <a href="/worlds/{{ $world->id }}/create-project">New Project</a></p>
  <form action="{{ route('create-project') }}" id="new-project" method="POST">Create a New Project in {{ $world->name }}!!
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