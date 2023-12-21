<section id="main-search-section" class="main-search items-center grid">
    <form class = "main-search" method="GET" action="{{ route('search') }}">
        <fieldset>
            <legend class="sr-only">Search</legend>
            @csrf

            <label class="sr-only" for="main-search-anything">Search for anything!</label>
            <input type="text" id="main-search-anything" name="anything" placeholder="Search anything" tabindex="0">

            <label hidden for="mainSearch-typeFilter">Filter by type</label>
            <select id="mainSearch-typeFilter" name="typeFilter" hidden>
                <option value="All" selected>All</option>
            </select>

            <label for ="mainSearch-order" hidden>Order by</label>
            <select id="mainSearch-order" name="order" hidden>
                <option value= "Relevance" selected>Relevance</option>
            </select>

            <input class="button" type="submit" id="mainSearchButton" value='Search' tabindex="0" title="Search">
        </fieldset>
    </form>
</section>
