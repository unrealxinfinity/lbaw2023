@if (Auth::user()->persistentUser->type_ === 'Member')
    <section class="main-search items-center grid">
        <form class = "main-search" method="GET" data-id="{{ $member->id }}" action="{{ route('search') }}">
            <fieldset>
                <legend class="sr-only">Search</legend>
                @csrf

                <label class="sr-only" for="anything">Search for anything!</label>
                <input type="text" id="anything" name="anything" placeholder="Search anything" required tabindex="0">

                <input type="hidden" name="member_id" value="{{ $member->id }}">

                <label hidden for="typeFilter">Filter by type</label>
                <select id="typeFilter" name="typeFilter" hidden>
                    <option value="All" selected>All</option>
                </select>

                <label for ="order" hidden>Order by</label>
                <select id="order" name="order" hidden>
                    <option value= "Relevance" selected>Relevance</option>
                </select>

                <input class="button" type="submit" id="mainSearchButton" value='Search' tabindex="0">
            </fieldset>
        </form>
    </section>
@endif