<form class = "search-task child:mx-0.5" data-id="{{ $project->id }}">
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
    <input id="searchTaskButton" class="button" type="submit" value="Search Tasks">
</form>

<div id="popupContainer" class="popup hidden z-20 bg-grey outline outline-white/20 outline-1 rounded fixed h-1/2 tablet:w-1/2 w-2/3 top-[30%] tablet:left-[23%] left-[15%] justify-center">
    <span id="closePopUp" class="my-2 mx-5 cursor-pointer">&times;</span>
    <div id="popup-content" class="p-2 h-5/6 overflow-y-scroll"></div>
</div>