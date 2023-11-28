    <form class = "search-project" data-id="{{ $world->id }}">
            @csrf
            <input type="text" id="projectName"name="projectName" placeholder="Project Name" required>
            <input type="hidden" name="world_id" value="{{ $world->id }}">
            <select id="order" name="order">
                <option value= "Relevance" selected>Relevance</option>
                <option value="A-Z">A-Z</option>
                <option value="Z-A">Z-A</option>
            </select>
            <input id="searchProjectButton" class="button" type="submit" value="Search Projects">
    </form>

<div id="popupContainer" class="popup z-20 bg-grey rounded fixed hidden shadow h-fit w-128 top-[35%] left-[25%] justify-center m-10">
    <span id="closePopUp" class="p-2 cursor-pointer">&times;</span>
    <div id="popup-content" class="px-5 py-2"></div>
</div>
