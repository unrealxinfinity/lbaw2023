<form class = "search-task" data-id="{{ $project->id }}">
       @csrf
       <input type="text" id="taskName"name="taskName" placeholder="Task Name">
       <input type="hidden" name="project_id" value="{{ $project->id }}">
       <input type="button" id="searchTaskButton" value='Search'></input>
</form>

<button id="openPopupButton">Open Results</button>
<div id="popupContainer" class="popup">
<div class="popup-content">
    <span class="close" onclick="closeSearchedTaskPopup()">&times;</span>
    <p>This is a pop-up!</p>
</div>
</div>
