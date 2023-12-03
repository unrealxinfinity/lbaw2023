@extends('layouts.app')

@section('title', "Confirm account deletion?")

@section('content')
    <section id="delete" class="grid grid-rows-3 grid-cols-1 content-center">
        @include('partials.delete', ['member' => $member])
    </section>
@endsection