@extends('layouts.app')

@section('title', 'My Worlds')

@section('content')

    <section id="myworlds">
        <h1>My Worlds</h1>
        <div class="row">
            @foreach($worlds as $world)
                <div class="col-md-4">
                    <span> {{ $world }} </span>
                </div>
            @endforeach
        </div>
    </section>
@endsection

