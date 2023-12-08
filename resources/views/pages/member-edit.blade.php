@extends('layouts.app')
@section('title', 'Edit' . $member->persistentUser->user->username)

@if (Auth::check() && (Auth::user()->id == $member->persistentUser->user->id || Auth::user()->persistentUser->type_=='Administrator'))
    @section('content')
        <section id="members">
            @include('partials.member-edit', ['member' => $member])
        </section>
    @endsection
@else
    @section('content')   
        <h3>You do not have access to this page!</h3>
        <h2><a href="/">Go Back</a></h2>
    @endsection
@endif


