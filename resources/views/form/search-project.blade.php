<div class='row'>
    <form class = "search-project" data-id="{{ $world->id }}>
        @csrf
        <input type="text" id="projectName"name="projectName" placeholder="Project Name">
        <input type="hidden" name="world_id" value="{{ $world->id }}">
        <input type="button" id="searchProjectButton" value='Search'>
    </form>
</div>

<button id="openPopupButton">Open Results</button>
<div id="popupContainer" class="popup">
    <span id="closePopUp">&times;</span>
    <div class="popup-content">
    </div>
</div>
