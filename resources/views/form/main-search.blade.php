<div class='row'>
    <form class = "main-search" method="GET" data-id="{{ $member->id }}" action="{{ route('search') }}">
        @csrf
        <input type="text" id="anything"name="anything" placeholder="Anything">
        <input type="hidden" name="member_id" value="{{ $member->id }}">
        <input type="submit" id="mainSearchButton" value='Search'>
    </form>
</div>
