
    <form class = "search-project" data-id="{{ $world->id }}">
        <div class='row'>
            @csrf
            <input type="text" id="projectName"name="projectName" placeholder="Project Name" required>
            <input type="hidden" name="world_id" value="{{ $world->id }}">
            <input class="button" type="button" id="searchProjectButton" value='Search'>
        </div>
    </form>
    <button id="openPopupButton">Open Results</button>


<div id="popupContainer" class="popup">
    <span id="closePopUp">&times;</span>
    <div class="popup-content">
    </div>
</div>
