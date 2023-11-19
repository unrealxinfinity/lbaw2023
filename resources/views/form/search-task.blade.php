<div class='row'>
    <form class="search-task" data-id="{{ $project->id }}">
        @csrf
        <input type="text" id="taskName"name="taskName" placeholder="Task Name">
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="button" id="searchTaskButton" value='Search'>
    </form>
</div>

<button id="openPopupButton">Open Results</button>
<div id="popupContainer" class="popup">
    <span id="closePopUp">&times;</span>
    <div class="popup-content">
    </div>
</div>
