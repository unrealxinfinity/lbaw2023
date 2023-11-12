@extends('layouts.app')

@section('title', $member->persistentUser->user->username)

@section('content')
    <section id="members">
        @include('partials.member', ['member' => $member])
    </section>
@endsection