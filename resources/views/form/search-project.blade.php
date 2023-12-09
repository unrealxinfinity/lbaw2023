<form class = "search-project child:mx-0.5" data-id="{{ $world->id }}">
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

<div id="popupContainer" class="popup hidden z-20 bg-dark outline outline-white/20 outline-1 rounded fixed h-1/2 tablet:w-1/2 w-2/3 top-[30%] tablet:left-[23%] left-[15%] justify-center">
    <h2 id="closePopUp" class="my-2 mx-5 cursor-pointer">&times;</h2>
    <div id="popup-content" class="p-2 h-5/6 overflow-y-scroll"></div>
</div>
