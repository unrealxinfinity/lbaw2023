@extends('layouts.app')

@section('title', $member->persistentUser->user->username)

@section('content')
    <section id="members">
        @include('partials.member', ['member' => $member, 'main' => true])
    </section>
    <h3> <a href = "/myworlds" >My Worlds</a></h3>
@endsection