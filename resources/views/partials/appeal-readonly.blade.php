@include('partials.member', ['member' => $appeal->member, 'main' => false, 'appeal' => false])
<h2>Reason for appeal</h2>
<p>{{ $member->appeal->text }}</p>
@if ($member->appeal->denied)
    <h2>Your appeal has been denied</h2>
@else
    <h2>Your appeal is under review</h2>
@endif