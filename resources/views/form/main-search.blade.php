@if (Auth::user()->persistentUser->type_ === 'Member')
    <section class="main-search">
        <form class = "main-search" method="GET" data-id="{{ $member->id }}" action="{{ route('search') }}">
            <div class="row">
                @csrf
                <input type="text" id="anything"name="anything" placeholder="Search anything" required>
                <input type="hidden" name="member_id" value="{{ $member->id }}">
                <input class="button" type="submit" id="mainSearchButton" value='Search'>
            </div>
        </form>
    </section>
@endif