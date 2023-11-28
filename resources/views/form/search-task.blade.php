<form class = "search-task" data-id="{{ $project->id }}">
    @csrf
    <input type="text" id="taskName"name="taskName" placeholder="Task Name" required>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <input id="searchTaskButton" class="button" type="submit" value="Search Tasks">
</form>
<div id="popupContainer" class="popup z-20 bg-grey rounded fixed hidden shadow h-fit w-128 top-[35%] left-[25%] justify-center m-10">
    <span id="closePopUp" class="p-2 cursor-pointer">&times;</span>
    <div id="popup-content" class="px-5 py-2">
    </div>
</div>