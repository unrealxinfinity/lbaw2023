<form class="search-project" data-id="{{ $world->id }}">
    <fieldset class="flex mobile:flex-row flex-col mobile:items-end child:mx-0.5">
        <legend>Search a Project</legend>
        @csrf
        <div class="flex flex-col mr-3">
            <h3 class="my-0 mt-3"> <label for="projectName">Project Name  <b class="text-red">*</b></label></h3>
            <input type="text" id="projectName" name="projectName" placeholder="Project Name" required>
        </div>
        <input type="hidden" name="world_id" value="{{ $world->id }}">
        <div class="flex flex-col mr-3">
            <h3 class="my-0 mt-3"> <label for="Tags">Tags</label></h3>
            <input type="text" id="Tags" name="tags" placeholder="tag1,tag2">
        </div>
        <div class="flex flex-col mr-3">
            <h3 class="my-0 mt-3"> <label for="project_order">Order</label></h3>
            <select id="project_order" name="order">
                <option value= "Relevance" selected>Relevance</option>
                <option value="A-Z">A-Z</option>
                <option value="Z-A">Z-A</option>
            </select>
        </div>
        <input id="searchProjectButton" class="button ml-3 tablet:h-8 h-7 py-1 my-2 mobile:my-0" type="submit" value="Search Projects">
    </fieldset>
</form>

<div id="popupContainer" class="popup hidden z-20 bg-dark outline outline-white/20 outline-1 rounded fixed h-1/2 tablet:w-1/2 w-2/3 top-[30%] tablet:left-[23%] left-[15%] justify-center">
    <h2 id="closePopUp" class="my-2 mx-5 cursor-pointer">&times;</h2>
    <div id="popup-content" class="p-2 h-5/6 overflow-y-scroll"></div>
</div>
