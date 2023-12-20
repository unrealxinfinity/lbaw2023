@extends('layouts.app')

@section('title', 'Create World')

@section('content')
<article class = "world">
    <p><a href="/">Home</a> > <a href="/create-world">New World</a></p>
    <form action="{{ route('create-world') }}" id="new-world" method="POST" class="form-outline">
      <fieldset class="form-post">
        <legend>Create a New World!</legend>
        @csrf
        @method('POST')
        
        <h3 class="my-0 mt-3"> <label for="name">Name <b class="text-red">*</b></label> </h3>
        <input type="text" name="name" id="name" placeholder="New World Name" required>
        @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
        </span>
        @endif

        <h3 class="my-0 mt-3"> <label for="description">Description <b class="text-red">*</b></label> </h3>
        <textarea type="text" name="description"  id="description" placeholder="Some non-blank text" required> </textarea>
        @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
        @endif

        <button class="button" type="submit">Create</button>
      </fieldset>
    </form>
</article>
@endsection