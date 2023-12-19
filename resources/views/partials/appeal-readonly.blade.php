
<div class="grid grid-lines-4 grid-cols-1 gap-4 p-1.5">
    <h2 class="justify-self-center">Reason for appeal</h2>
    <p class="justify-self-center">{{ $member->appeal->text }}</p>
    @if ($member->appeal->denied)
        <h2 class="bg-mine-red justify-self-center p-3">Your appeal has been denied</h2>
    @else
        <h2 class="bg-mine-red justify-self-center p-3">Your appeal is under review</h2>
    @endif
</div>