@extends('layouts.app')

@section('title', 'Administer members')

@section('content')
    <section id="members">
        @each('partials.member-edit', $members, 'member')
    </section>
@endsection