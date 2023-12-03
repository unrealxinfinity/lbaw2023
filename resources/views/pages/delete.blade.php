@extends('layouts.app')

@section('title', "Confirm account deletion?")

@section('content')
    <section id="delete" class="flex flex-col items-center">
        @include('partials.delete', ['member' => $member])
    </section>
@endsection