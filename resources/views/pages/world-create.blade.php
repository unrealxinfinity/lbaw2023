@extends('layouts.app')

@section('title', 'Create World')

@section('content')
<article class = "world">

    <form action="{{ route('create-world') }}" id="new-world" method="POST">Create a New World!!
        @csrf
        @method('POST')

        <input type="text" name="name" placeholder="New World Name">
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