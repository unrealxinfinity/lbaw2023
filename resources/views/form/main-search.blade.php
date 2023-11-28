@if (Auth::user()->persistentUser->type_ === 'Member')
    <section class="main-search">
        <form class = "main-search" method="GET" data-id="{{ $member->id }}" action="{{ route('search') }}">
            <div>
                @csrf
                <input type="text" id="anything"name="anything" placeholder="Search anything" required>
                <input type="hidden" name="member_id" value="{{ $member->id }}">
                <select id="typeFilter" name="typeFilter">
                    <option value="All" selected>All</option>
                    <option value="World">World</option>
                    <option value="Project" >Project</option>
                    <option value="Task">Task</option>
                    <option value="Member">Member</option>
                </select>
                <select id="order" name="order">
                    <option value= "Relevance" selected>Relevance</option>
                    <option value="A-Z">A-Z</option>
                    <option value="Z-A">Z-A</option>
                </select>
                <input class="button" type="submit" id="mainSearchButton" value='Search'>
            </div>
        </form>
    </section>
@endif