@extends('layouts.app')

@section('title', $member->persistentUser->user->username)

@section('content')
    <section id="members">
        @include('partials-member-edit', ['member' => $member])
    </section>
    <h3> <a href = "/myworlds" >My Worlds</a></h3>
@endsection