@extends('layouts.app')

@section('title', 'Create World')

@section('content')
<article class = "world">

    <form action="{{ route('create-task') }}" id="new-world" method="POST">Create a New World!!
        @csrf
        @method('POST')

        <input type="text" name="name" placeholder="New World Name">
        <input type="text" name="description" placeholder="Description">

        <button type="submit">Create</button>

    </form>
</article>
@endsection