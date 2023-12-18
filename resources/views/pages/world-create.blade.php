@extends('layouts.app')

@section('title', 'Create World')

@section('content')
<article class = "world">
    <p><a href="/">Home</a> > <a href="/create-world">New World</a></p>
    <form action="{{ route('create-world') }}" id="new-world" method="POST" class="form-post">Create a New World!!
        @csrf
        @method('POST')
        
        <h3 class="my-0 mt-3"> <label for="name">Name:</label> </h3>
        <input type="text" name="name" id="name" placeholder="New World Name">
        @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
        </span>
        @endif

        <h3 class="my-0 mt-3"> <label for="description">Description:</label> </h3>
        <textarea type="text" name="description"  id="description" placeholder="Description"> </textarea>
        @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
        @endif

        <button class="button" type="submit">Create</button>

    </form>
</article>
@endsection