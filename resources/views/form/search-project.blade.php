<form class = "search-project" data-id="{{ $world->id }}">
    @csrf
    <input type="text" id="projectName"name="projectName" placeholder="Project Name" required>
    <input type="hidden" name="world_id" value="{{ $world->id }}">
    <input id="searchProjectButton" class="button" type="submit" value="Search Projects">
</form>

<div id="popupContainer" class="popup z-20 bg-grey rounded fixed hidden top-1/2 left-1/2 justify-center m-10">
    <span id="closePopUp" class="p-2 cursor-pointer">&times;</span>
    <div id="popup-content" class="px-5 py-2">
    </div>
</div>
