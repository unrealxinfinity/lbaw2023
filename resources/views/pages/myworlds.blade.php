@extends('layouts.app')

@section('title', 'My Worlds')

@section('content')

    <section id="myworlds">
        <h1>My Worlds</h1>
        <div>
            @each('partials.myworlds', $worlds, 'world')
        </div>
    </section>
@endsection

