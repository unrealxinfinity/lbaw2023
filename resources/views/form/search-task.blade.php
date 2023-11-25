<article class="search-tasks">
        <form class = "search-task" data-id="{{ $project->id }}">
            <div class='row'>
                @csrf
                <input type="text" id="taskName"name="taskName" placeholder="Task Name" required>
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <select id="order" name="order">
                    <option value= "Relevance" selected>Relevance</option>
                    <option value="A-Z">A-Z</option>
                    <option value="Z-A">Z-A</option>
                    <option value="DueDateAscendent">Due Date Ascendent</option>
                    <option value="DueDateDescendent">Due Date Descendent</option>
                    <option value="EffortAscendent">Effort Ascendent</option>
                    <option value="EffortDescendent">Effort Descendent</option>
                </select>
                <input class="button" type="button" id="searchTaskButton" value='Search'>
        </div>
    </form>
    <button id="openPopupButton">Open Results</button>
    <div id="popupContainer" class="popup">
        <span id="closePopUp">&times;</span>
        <div class="popup-content">
        </div>
    </div>
</article>