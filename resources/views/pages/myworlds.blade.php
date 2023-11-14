@extends('layouts.app')

@section('title', 'My Worlds')

@section('content')

    <section id="myworlds">
        <h1>My Worlds</h1>
        <div class="row">
            @each('partials.world', $worlds, 'world')
        </div>
    </section>
@endsection

