function addEventListeners() {
  let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
  [].forEach.call(itemCheckers, function(checker) {
    checker.addEventListener('change', sendItemUpdateRequest);
  });

  let itemCreators = document.querySelectorAll('article.card form.new_item');
  [].forEach.call(itemCreators, function(creator) {
    creator.addEventListener('submit', sendCreateItemRequest);
  });

  let itemDeleters = document.querySelectorAll('article.card li a.delete');
  [].forEach.call(itemDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteItemRequest);
  });

  let cardDeleters = document.querySelectorAll('article.card header a.delete');
  [].forEach.call(cardDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteCardRequest);
  });

  let friendButtons = document.querySelectorAll('.friend-button');
    [].forEach.call(friendButtons, function(friendButton) {
      friendButton.addEventListener('click', sendFriendRequest);
    });


  let cardCreator = document.querySelector('article.card form.new_card');
  if (cardCreator != null)
    cardCreator.addEventListener('submit', sendCreateCardRequest);

  let memberEditors =document.querySelectorAll('form.edit-member');
  [].forEach.call(memberEditors, function(editor) {
    editor.querySelector('.button').addEventListener('submit', sendEditMemberRequest);
  });

  let tasks = document.querySelectorAll('article.task');
  [].forEach.call(tasks, function(task) {
    task.addEventListener("dragstart", taskDragStartHandler);
  });

  let bigboxes = document.querySelectorAll('div.big-box');
  [].forEach.call(bigboxes, function(bigbox) {
    bigbox.addEventListener("drop", bigBoxDropHandler);
    bigbox.addEventListener("dragover", bigBoxDragOverHandler);
  })

  let editorShows = document.querySelectorAll('button.show-edit');
  [].forEach.call(editorShows, function(editorShow) {
    editorShow.addEventListener('click', showEditComment);
  });

  let editorHides = document.querySelectorAll('button.close-edit');
  [].forEach.call(editorHides, function(editorHide) {
     editorHide.addEventListener('click', hideEditComment);
  });

  let memberAdder = document.querySelector('form#add-member');
  if (memberAdder != null)
    memberAdder.addEventListener('submit', sendAddMemberRequest);

  let button = document.getElementById("createTagButton");
  let TagForm = document.getElementsByClassName('new-tag');
  if(TagForm != null){
    for(let i = 0; i < TagForm.length; i++){
      TagForm[i].addEventListener('submit', addTagRequest);
    }
  }
  if(button != null) button.addEventListener("click", addTagRequest);

  let deleteTagForms = document.getElementsByClassName('delete-tag');
  if(deleteTagForms != null){
    for(let i = 0; i < deleteTagForms.length; i++){
      deleteTagForms[i].querySelector('#deleteTagButton').addEventListener('click', sendDeleteTagRequest);
    }
  }

  
  let worldMemberAdder = document.querySelectorAll('form#invite-member');
  if (worldMemberAdder != null){
    [].forEach.call(worldMemberAdder, function(form) {
      form.addEventListener('submit', sendInviteMember);
    });
  }

  let worldNewMemberAdder = document.querySelectorAll('form#invite-new-member');
  if (worldNewMemberAdder != null){
    [].forEach.call(worldMemberAdder, function(form) {
      form.addEventListener('submit', sendInviteNewMember);
    });
  }

  let taskResults = document.getElementById('openPopupButton');
  if(taskResults != null)
    taskResults.addEventListener('click', function() {
      if(document.getElementById('popupContainer').style.display == 'block'){
        document.getElementById('popupContainer').style.display = 'none';
      }
      else{
        document.getElementById('popupContainer').style.display = 'block';
      }
    });

  let TaskSearcher = document.querySelector('form.search-task');
  if (TaskSearcher != null)
    TaskSearcher.addEventListener('submit', searchTaskRequest);

  let ProjectSearcher = document.querySelector('form.search-project');
  if (ProjectSearcher != null)
    ProjectSearcher.addEventListener('submit', searchProjectRequest);
  
  let MemberAssigner = document.querySelectorAll('form#assign-member');
  if (MemberAssigner != null){
    [].forEach.call(MemberAssigner, function(form) {
      form.addEventListener('submit', sendAssignMemberRequest);
    });
  }
  
  let closePopup = document.getElementById('closePopUp');
  if(closePopup != null)
    closePopup.addEventListener('click', closeSearchedTaskPopup);
  
  let removeMemberFromWorlds = document.querySelectorAll('form#remove-member-world');
  if(removeMemberFromWorlds != null){
    removeMemberFromWorlds.forEach(removeMemberFromWorld => {
      removeMemberFromWorld.addEventListener('submit', sendRemoveMemberFromWorldRequest);
    });
  }

  let createTask = document.getElementById("createTaskButton");
  if(createTask != null)
    createTask.addEventListener("click", sendCreateTaskRequest);

  let lastScrollTop = 0;
  window.addEventListener('scroll', function() {
    let currentScroll = document.documentElement.scrollTop;
    let showMenu = document.querySelector('#show-menu');
    let showNotif = document.querySelector('#notificationArea').classList.contains('hidden');
  
    if (currentScroll > lastScrollTop) {
      // Scroll down
      if (!showMenu.checked && showNotif) {
      document.querySelector('#navbar').classList.remove('translate-y-0');
      document.querySelector('#navbar').classList.add('-translate-y-full');
      }
    } else {
      // Scroll up
      document.querySelector('#navbar').classList.remove('-translate-y-full');
      document.querySelector('#navbar').classList.add('translate-y-0');
    }
  
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  }, false);

  let main = document.querySelector('main');
  main.addEventListener('click', function() {
    let showMenu = document.querySelector('#show-menu');
    let showNotif = document.querySelector('#notificationArea').classList.contains('hidden');
    if (showMenu.checked) {
      document.querySelector('#show-menu').checked = false;
    }
    if (!showNotif) {
      document.querySelector('#notificationArea').classList.toggle('hidden');
    }
  });
  
  let main_body = document.getElementById('main-body');
  if(main_body.getAttribute('data-auth') == 'true'){
    window.addEventListener('load',getMemberBelongingsRequest);
  }
  /*
  let removeMemberFromWorld = document.querySelector('');
  if(leaveWorld != null){
    leaveWorld.addEventListener('submit', sendLeaveWorldRequest);
  }
  */ 
  
  let notificationButton = document.getElementById('notification-button');
  if(notificationButton != null){
    notificationButton.addEventListener('click', sendShowNotificationsRequest);
  }

  let mcImgConfirm = document.getElementById('mc-img-submit');
  if (mcImgConfirm != null) {
    mcImgConfirm.addEventListener('click', replaceImage);
  }

  let clearNotificationsButton = document.getElementById('clearNotifications');
  if(clearNotificationsButton != null){
    clearNotificationsButton.addEventListener('click', sendClearNotificationsRequest);
  }


  let ProjectEditCloser = document.querySelector('#go-back');
  if (ProjectEditCloser != null)
  ProjectEditCloser.addEventListener('click', function() {
      window.history.back();
    });

  let removeMemberFromProjects = document.querySelectorAll('form#remove-member-project');
  if(removeMemberFromProjects != null){
    removeMemberFromProjects.forEach(removeMemberFromProject => {
      removeMemberFromProject.addEventListener('submit', sendRemoveMemberFromProjectRequest);
    });
  }
  
  let assignAdminToWorld = document.querySelectorAll('form.assign-admin-to-world');
  if(assignAdminToWorld != null){
    assignAdminToWorld.forEach(form => {
     form.addEventListener('submit', sendAssignAdminToWorldRequest);
    });
  }
  let demoteAdminFromWorld = document.querySelectorAll('form.demote-admin-from-world');
  if(demoteAdminFromWorld != null){
    demoteAdminFromWorld.forEach(form => {
     form.addEventListener('submit', sendDemoteAdminFromWorldRequest);
    });
  }
  
  let assignProjectLeader = document.querySelectorAll('form.assign-project-leader');
    if(assignProjectLeader != null){
      assignProjectLeader.forEach(form => {
        form.addEventListener('submit', sendAssignProjectLeaderRequest);
      });
    }
    let demoteProjectLeader = document.querySelectorAll('form.demote-project-leader');
    if(demoteProjectLeader != null){  
      demoteProjectLeader.forEach(form => {
        form.addEventListener('submit', sendDemoteProjectLeaderRequest);
      });
    }  
  let deleteAccount = document.querySelector("#delete-account");
  if (deleteAccount != null)
    deleteAccount.addEventListener('click', deleteAccountButton);

  let confirmDeletion = document.querySelector("#confirm-deletion");
  if (confirmDeletion != null)
    setTimeout(() => {
      confirmDeletion.submit();
    }, 5000);
    
  let deleteWorld= document.querySelector("#delete-world");
  if (deleteWorld != null)
    deleteWorld.addEventListener('submit', deleteWorldButton);

  let deleteWorldInList = document.querySelectorAll("form.delete-world-list");
  if (deleteWorldInList != null){
    [].forEach.call(deleteWorldInList, function(form) {
      form.addEventListener('submit', deleteWorldAjaxButton);
    });
  }
  
  let leaveWorldInList = document.querySelectorAll("form.leave-world-list");
  if (leaveWorldInList != null){
    [].forEach.call(leaveWorldInList, function(form) {
      form.addEventListener('submit', sendLeaveWorldRequest);
    });
  }

  let previewImg = document.querySelector('input#edit-img');
  if (previewImg != null) {
    previewImg.addEventListener('change', PreviewImageHandler);
  }

  let favouriter = document.querySelector('form#favorite');
  if (favouriter != null)
  favouriter.addEventListener('submit', sendFavoriteRequest);

  let changeInviteType = document.querySelectorAll('#invite-outside-member');
  if (changeInviteType != null){
    [].forEach.call(changeInviteType, function(button) {
      button.addEventListener('click', changeToInviteOutsideMember);
    });
  }

  let inviteOutsideMember = document.querySelector('form#invite-new-member');
  if (inviteOutsideMember != null){
    inviteOutsideMember.addEventListener('submit', sendInviteNewMember);
  }
  let leave_project = document.getElementsByClassName('leave-project');
  if(leave_project != null){
    [].forEach.call(leave_project, function(form) {
      form.addEventListener('submit', leaveProjectAlert);
    });
  }
  let delete_project = document.getElementsByClassName('delete-project');
  if(delete_project != null){
    [].forEach.call(delete_project, function(form) {
      form.addEventListener('submit', deleteProjectAlert);
    });
  }
  let leave_world = document.getElementsByClassName('leave-world');
  if(leave_world != null){
    [].forEach.call(leave_world, function(form) {
      form.addEventListener('submit', leaveWorldAlert);
    });
  }
  let archive_project = document.getElementsByClassName('archive-project');
  if(archive_project != null){
    [].forEach.call(archive_project, function(form) {
      form.addEventListener('submit', archiveProjectAlert);
    });
  }
}
function leaveProjectAlert(ev) {
  ev.preventDefault();
  confirmationAlert("Are you sure you want to leave this project?","This action can't be reverted!", "Left the project successfully!","", "Leave", this.submit.bind(this),1000);
}
function deleteProjectAlert(ev) {
  ev.preventDefault();
  confirmationAlert("Are you sure you want to delete this project?","This action can't be reverted!", "Deleted the project successfully!","", "Delete", this.submit.bind(this),1000);
}
function leaveWorldAlert(ev) {
  ev.preventDefault();
  confirmationAlert("Are you sure you want to leave this world?","This action can't be reverted!", "Left the world successfully!","", "Leave", this.submit.bind(this),1000);
}
function archiveProjectAlert(ev) {
  ev.preventDefault();
  confirmationAlert("Are you sure you want to archive this project?","This action can't be reverted!", "Archived the project successfully!","", "Archive", this.submit.bind(this),1000);
}
  
async function replaceImage(ev) {
  const username = document.getElementById('mc-username-text').value;
  const img = await fetch('https://mc-heads.net/avatar/${username}.png');
  const blob = await img.blob();
  const myFile = new File([blob], 'profile.png');


  const dataTransfer = new DataTransfer();
  dataTransfer.items.add(myFile);//your file(s) reference(s)
  document.querySelector('#edit-img').files = dataTransfer.files;
  
  ev.target.closest('form').submit();
}

function changeToInviteOutsideMember(ev) {
  ev.preventDefault();
  let outsideForm = document.querySelector('form#invite-new-member');
  let insideForm = document.querySelector('form#invite-member');


  if(outsideForm.classList.contains('hidden')){
    outsideForm.classList.remove('hidden');
    insideForm.classList.add('hidden');
  } else{
    outsideForm.classList.add('hidden');
    insideForm.classList.remove('hidden');
  }
}


  async function sendFriendRequest(ev) {
    ev.preventDefault();
    const url = this.href;

    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': "application/json",
        'Accept': 'application/json',
      }
    });

    if (response.ok) this.remove();
  }

  
  async function deleteAccountButton() {
    let confirm = "";
    const { value: confirmation } = await Swal.fire({
      title: "Are you sure you want to delete your account?",
      imageUrl: "/images/dog.png",
      imageWidth: 200,
      imageHeight: 200,
      ImageAlt: "A cute dog looking at you.",
      inputLabel: "Type 'Delete' to confirm:",
      input: "text",
      confirm,
      showCancelButton: true,
      customClass:{
        popup: 'rounded-3xl',
        confirmButton: 'rounded-2xl bg-red',
        cancelButton: 'rounded-2xl',
      },
      inputValidator: (value) => {
        if (!value) {
          return "You need to write something!";
        }
        else if(value !== "Delete"){
          return "Input isn't 'Delete'!";
        }
      }
    });
    if (confirmation === "Delete") {
      
        setInterval(() => {
          window.location.href = window.location.href + '/delete'

        }, 2000);
        Swal.fire({
          title:'Account Successfully deleted!',
          icon: "success",
          showConfirmButton: false,
        });
      
    }
  }
  async function deleteWorldButton(ev) {
    ev.preventDefault();
    confirmationAlert("Are you sure you want to delete this world?", "This action can't be reverted!","World Successfully deleted!","", "Delete", this.submit.bind(this),3000);
  }
  

  async function deleteWorldAjaxButton(ev) {
    ev.preventDefault();
    async function request(){
          const csrf = this.querySelector('input:first-child').value;
          const id = this.querySelector('input.id').value;
          const response = await fetch('/api/worlds/' + id, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': csrf,
              'Content-Type': "application/json",
              'Accept': 'application/json',
              "X-Requested-With": "XMLHttpRequest"
            }
          }).then(response => {
            if(response.ok){
              return response.json();
            }
            else{
              throw new Error('Response status not OK');
            }
          }).then(data => {
            removeWorldFromListHandler(data);
          }).catch(error => console.error('Error fetching data:', error.message));    
    }
    confirmationAlert("Are you sure you want to delete this world?","This action can't be reverted", "World Successfully deleted!","", "Delete", request.bind(this),0);

  }

  function removeWorldFromListHandler(data) {
    let element = document.querySelectorAll('.myworld[data-id="' + data.id + '"]');
    [].forEach.call(element, function(world) {
      world.remove();
    });
  }

  function leaveWorldFromListHandler(data) {
    if (window.location.pathname === '/myworlds') {
        console.log("You're in /myworlds");
        let element = document.querySelectorAll('.myworld[data-id="' + data.id + '"]');
        [].forEach.call(element, function(world) {
          world.remove();
        });
    } else if (window.location.pathname === '/worlds') {
        console.log("You're in /worlds");
        let checkbox = document.querySelector('#more-options-' + data.id);
        if (checkbox) {
            checkbox.checked = false;
        }

        let element = document.querySelector('#h1-'+ data.id);
        if (element) {
            element.remove();
        }

    }
}

  async function sendLeaveWorldRequest(ev) {
    ev.preventDefault();
    async function request(){
      const csrf = this.querySelector('input:first-child').value;
      const id = this.querySelector('input.id').value;
      const username = this.querySelector('input.username').value;
      const response = await fetch('/api/worlds/' + id + '/' + username, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Content-Type': "application/json",
          'Accept': 'application/json',
          "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({id: id, username: username})
      }).then(response => {
        if(response.ok){
          return response.json();
        }
        else{
          throw new Error('Response status not OK');
        }
      }).then(data => {
        leaveWorldFromListHandler(data);
      }).catch(error => console.error('Error fetching data:', error.message));
    }
    confirmationAlert("Are you sure you want to leave this world?","This action can't be reverted!", "Left the world successfully!","", "Leave", request.bind(this),2000);
   
  }

  function showEditComment(ev) {
    ev.preventDefault();
    this.closest('article').querySelector('h4.comment-content').classList.add('hidden');
    this.closest('article').querySelector('div.comment-edit').classList.remove('hidden');
    this.classList.add('hidden');
  }

  function hideEditComment(ev) {
    ev.preventDefault();
    this.closest('article').querySelector('h4.comment-content').classList.remove('hidden');
    this.closest('div.comment-edit').classList.add('hidden');
    this.closest('article').querySelector('button.show-edit').classList.remove('hidden');
  }

  function bigBoxDragOverHandler(ev) {
    ev.preventDefault();
    ev.dataTransfer.dropEffect = "move";
  }

  async function bigBoxDropHandler(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text/plain");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const box = ev.currentTarget;
    const status = box.querySelector('h3').textContent;

    const response = await fetch('/api/tasks/' + data.slice(5), {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({status: status})
    });

    if (response.status === 200) {
      box.appendChild(document.getElementById(data));
    }
  }

  function taskDragStartHandler(ev) {
    ev.dataTransfer.setData("text/plain", ev.target.id);
    ev.dataTransfer.setData("text/html", ev.target.outerHTML);
    ev.dataTransfer.setData(
      "text/uri-list",
      ev.target.ownerDocument.location.href,
    );
    ev.dataTransfer.dropEffect = "move";
  }

  function PreviewImageHandler(event) {
    let selectedFile = event.target.files[0];
    let img = document.querySelector('img#preview-img');
    img.src = URL.createObjectURL(selectedFile);
  }
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
  function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
  
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }

  function sendEditMemberRequest() {
    let form = this.closest('form.edit-member');
    let name = form.querySelector('input.name').value;
    let email = form.querySelector('input.email').value;
    let birthday = form.querySelector('input.birthday').value;
    let description = form.querySelector('input.description').value;

    let id = form.querySelector('input.member-id').value;

    sendAjaxRequest('put', '/api/members/' + id, {name: name, email: email, birthday: birthday, description: description}, editMemberHandler);
  }

  async function sendAddMemberRequest(event) {
    event.preventDefault();

    const username = this.querySelector('input.username').value;
    const id = this.querySelector('input.id').value;
    const csrf = this.querySelector('input:first-child').value;
    const type = this.querySelector('select.type').value;

    const response = await fetch('/api/projects/' + id + '/' + username, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({type: type})
    });

    const json = await response.json();
    
    if (response.status !== 500) addMemberHandler(json);
  }

  function addMemberHandler(json) {
    const list = document.querySelectorAll('ul.members');
    [].forEach.call(list, function(ul) {
      const form = document.querySelector('form.add-member');
      const error = form.querySelector('span.error');
      if (error !== null)
      {
        error.remove();
      }
      
      if (json.error)
      {
        const span = document.createElement('span');
        span.classList.add('error');
        const members =  [... ul.querySelectorAll('article.member h4 a')].map(x => x.textContent);
        const index = members.find(x => x === json.username);
        if (index === undefined) span.textContent = 'Please check that ' + json.username + ' belongs to this ' + json.child + '\'s ' + json.parent + '.';
        else span.textContent = json.username + ' is already a member of this ' + json.child + '.';
        form.appendChild(span);
        return;
      }
      const member = document.createElement('article');
  
      member.classList.add('member');
      member.setAttribute('data-id', json.id);
  
      const header = document.createElement('header');
      header.classList.add('h-fit', 'flex', 'justify-start');
      const img = document.createElement('img');
      img.classList.add('h-5', 'aspect-square', 'mr-3');
      const h4 = document.createElement('h4');
      h4.classList.add('self-center');
      const a = document.createElement('a');
      a.href = '/members/' + json.username;
      a.textContent = json.username;
      img.src = json.picture;
      
      h4.appendChild(a);
      header.appendChild(img);
      header.appendChild(h4);
  
      member.appendChild(header);

      const div = document.createElement('div');
      const options_div = document.createElement('div');
      div.classList.add('h-5', 'flex', 'items-center', 'justify-between');
      options_div.classList.add('flex', 'items-center', 'child:mx-1');
      div.appendChild(member);

      if (json.can_move) {

        const moveForm = document.createElement('form');
        moveForm.setAttribute('data-id', json.id);
        let csrfToken_ = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (json.is_leader) {
          moveForm.id= 'demote-project-leader';

          moveForm.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken_}">
            <input type="hidden" class="id" name="id" value="${json.project_id}">
            <input type="text" class="username" name="username" value="${json.username}" hidden>
            <input class="button bg-grey p-0 px-2" type="submit" value="Demote">
          `;

            options_div.appendChild(moveForm);
            moveForm.addEventListener('submit', sendDemoteProjectLeaderRequest);
        } else {
          moveForm.id= 'assign-project-leader';

          moveForm.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken_}">
            <input type="hidden" class="id" name="id" value="${json.project_id}">
            <input type="text" class="username" name="username" value="${json.username}" hidden>
            <input class="button bg-grey p-0 px-2" type="submit" value="Promote">
          `;
          options_div.appendChild(moveForm);
          moveForm.addEventListener('submit', sendAssignProjectLeaderRequest);
        }
      }
      if (json.can_remove) {
        const removeForm = document.createElement('form');
        removeForm.id= 'remove-member-project';
        removeForm.setAttribute('data-id', json.id);
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
        removeForm.innerHTML = `
          <input type="hidden" name="_token" value="${csrfToken}">
          <input type="hidden" class="id" name="id" value="${json.project_id}">
          <input type="hidden" class="username" name="username" value="${json.username}">
          <button type="submit"> &times; </button>
        `;

        options_div.appendChild(removeForm);
        removeForm.addEventListener('submit', sendRemoveMemberFromProjectRequest);
      }
      div.append(options_div);
      let section = json.is_leader? ul.querySelector('#project-leaders'):ul.querySelector('#members');
      section.appendChild(div);
    });
  }

  function inviteMemberHandler(json) {
    const list = document.querySelectorAll('ul.members');
    [].forEach.call(list, function(ul) {
      const form = document.querySelector('form#invite-member');
      const error = form.querySelector('span.error');
      const invitation = form.querySelectorAll('span.success');
      if (invitation.length !== 0)
      {
        invitation.forEach(element => {
          element.remove();
        });
      }
      if (error !== null)
      {
        error.remove();
      }
  
      if (json.error)
      {
        const span = document.createElement('span');
        span.classList.add('error');
        const members =  [... ul.querySelectorAll('article.member h4 a')].map(x => x.textContent);
        const index = members.find(x => x === json.username);
        if (index === undefined) span.textContent = 'Please check if ' + json.username + ' already belongs to this world.';
        else span.textContent = json.username + ' is already a member of this world.';
        form.appendChild(span);
        return;
      }
  
      const span = document.createElement('span');
      span.classList.add('success');
      span.textContent = json.username + ' has been invited to join this world.';
      form.appendChild(span);
    });
  } 

  async function sendInviteMember(event){
      event.preventDefault();

      const username= this.querySelector('input.username').value;
      const id = this.querySelector('input.world_id').value;
      const csrf = this.querySelector('input:first-child').value;
      const type = this.querySelector('select.type').value;

      const response = await fetch('/api/worlds/' + id + '/invite', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Content-Type': "application/json",
          'Accept': 'application/json',
          "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({username: username, type: type, email: null})
      });

      const json = await response.json();

      if (response.status !== 500) inviteMemberHandler(json);
  }

  async function sendInviteNewMember(event){
    event.preventDefault();

    const email= this.querySelector('input.email').value;
    const id = this.querySelector('input.world_id').value;
    const csrf = this.querySelector('input:first-child').value;
    const type = this.querySelector('select.type').value;

    const response = await fetch('/api/worlds/' + id + '/invite', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({email: email, type: type, username: null})
    });

    const json = await response.json();

    if (response.status !== 500) inviteNewMemberHandler(json);
}

function inviteNewMemberHandler(json) {
  const list = document.querySelectorAll('ul.members');
  [].forEach.call(list, function(ul) {
    const form = document.querySelector('form#invite-new-member');
    const error = form.querySelector('span.error');
    const invitation = form.querySelectorAll('span.success');
    if (invitation.length !== 0)
    {
      invitation.forEach(element => {
        element.remove();
      });
    }
    if (error !== null)
    {
      error.remove();
    }

    if (json.error)
    {
      const span = document.createElement('span');
      span.classList.add('error');
      span.textContent = json.message;
      form.appendChild(span);
      return;
    }

    const span = document.createElement('span');
    span.classList.add('success');
    span.textContent = json.email + ' has been invited to join this world.';
    form.appendChild(span);
  });
}


  async function sendAssignMemberRequest(event) {
    event.preventDefault();
    const username = this.querySelector('input.username').value;
    const id = this.querySelector('input.id').value;
    const csrf = this.querySelector('input:first-child').value;
    
    const response = await fetch('/api/tasks/' + id + '/' + username, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      }
    });

    const json = await response.json();
    
    if (response.status !== 500) addMemberHandler(json);
  }

  function editMemberHandler() {

  }
  function sendCreateTaskRequest1(event) {
    event.preventDefault();
    
  }
  function sendCreateTaskRequest() {
    let form = this.closest('form.new-task');
    let title = form.querySelector('input.title').value;
    let description = form.querySelector('input.description').value;
    let due_at = form.querySelector('input.due_at').value;
    let effort = form.querySelector('input.effort').value;
    let priority = form.querySelector('select.priority').value;
    let project_id = form.querySelector('input.project_id').value;

    sendAjaxRequest('put', '/tasks', {title: title, description: description, due_at: due_at, effort: effort, priority: priority, project_id: project_id}, taskAddedHandler);
  }

  function taskAddedHandler() {

  }


  async function searchTaskRequest(event) {
    event.preventDefault();
    const searchTaskForms = document.getElementsByClassName('search-task');
    const id = searchTaskForms[0].getAttribute('data-id');
    let searchTaskElems = searchTaskForms[0];
    let searchedTask = searchTaskElems[1].value;
    const csrf = searchTaskElems[0].value;
    let order = searchTaskElems[3].value;

    const url = '/api/projects/' + id + '/tasks?search=' + searchedTask + '&order=' + order;

    const response = await fetch(url, {
        method: 'GET', 
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf, 
        },
    })
      .then(response =>{
            if(response.ok){
              return response.json();
            }
            else{
              throw new Error('Response status not OK');
            }
      })
      .then(data => {
          searchTaskHandler(data);
      })
      .catch(error => console.error('Error fetching data:', error));
      
}

  function searchTaskHandler(json){
    let popup = document.querySelector('#popup-content');
    popup.innerHTML = "";

    let tasks = JSON.parse(json.tasks);
    for (let task of tasks) {

      let result_div = document.createElement('div');
      result_div.classList.add('h-fit', 'self-center', 'p-3', 'mx-1', 'my-4', 'bg-black', 'outline', 'outline-1', 'outline-white/20', 'rounded');
      let title = document.createElement('h2');
      let link = document.createElement('a');
      let desc = document.createElement('h4');

      link.setAttribute('href', '/tasks/' + task.id);
      link.textContent = task.title;
      desc.textContent = task.description;
      title.appendChild(link);
      result_div.appendChild(title);
      result_div.appendChild(desc); 
      popup.appendChild(result_div);
    };
    document.getElementById('popupContainer').classList.remove('hidden');
  }

  async function searchProjectRequest(event) {
    event.preventDefault();
    const searchProjectForms = document.getElementsByClassName('search-project');
    const id = searchProjectForms[0].getAttribute('data-id');
    let searchProjectElems = searchProjectForms[0];
    let searchedProject = searchProjectElems[1].value;
    const csrf = searchProjectElems[0].value;
    let tags= searchProjectElems[3].value;
    let order = searchProjectElems[4].value;
    let url = '/api/worlds/'+ id +'/projects?search=' + searchedProject + '&order=' + order + '&tags=' + tags;
    const response = await fetch(url, {
      method: 'GET', 
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf, 
      },
  })
    .then(response =>{
            if(response.ok){
              return response.json();
            }
            else{
              throw new Error('Response status not OK');
            }
      })
      .then(data => {
          searchProjectHandler(data);
      })
      .catch(error => console.error('Error fetching data:', error));
      
}

function searchProjectHandler(json){
  let popup = document.querySelector('#popup-content');
  popup.innerHTML = "";

  let projects = JSON.parse(json.projects);
  for (let project of projects) {

    let result_div = document.createElement('div');
    result_div.classList.add('flex', 'h-fit', 'p-3', 'mx-1', 'my-2', 'bg-black/60', 'outline', 'outline-white/20', 'outline-1', 'rounded');
    let img = document.createElement('img');
    img.classList.add('mobile:h-14', 'tablet:h-16', 'desktop:h-20', 'h-12', 'aspect-square');
    let text_div = document.createElement('div');
    text_div.classList.add('flex', 'flex-col', 'self-center', 'ml-3', 'w-11/12');
    let title = document.createElement('h2');
    title.classList.add('break-words');
    let link = document.createElement('a');
    let desc = document.createElement('h4');
    desc.classList.add('break-words');

    link.setAttribute('href', '/projects/' + project.id);
    img.src = project.picture;
    link.textContent = project.name;
    desc.textContent = project.description;
    title.appendChild(link);
    result_div.appendChild(img);
    text_div.appendChild(title);
    text_div.appendChild(desc);
    result_div.appendChild(text_div);
    popup.appendChild(result_div);
  };
  document.getElementById('popupContainer').classList.remove('hidden');
}

  async function addTagRequest() {
    
    const tagForms = document.getElementsByClassName('new-tag');
    const id = tagForms[0].getAttribute('data-id');
    const type = tagForms[0].getAttribute('data-type');
    let tagElem = tagForms[0].children;
    let tagName= tagElem[2].value;
    const csrf = tagElem[0].value;
    let url= "";
    if(type == "project"){
       url = '/api/projects/' + id + '/' +'tags/create';
    }
    else if(type == "world"){
       url = '/api/worlds/' + id + '/' +'tags/create';
    }
    else if(type == "member"){
      url = '/api/members/' + id + '/' +'tags/create';
    }
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ tagName: tagName})
      })
      .then(response =>{
            if(response.ok){
              return response.json();
            }
            else{
              throw new Error('Response status not OK');
            }
      })
      .then(data => {
          addTagHandler(data);
      })
      .catch(error => console.error('Error fetching data:', error));
      tagElem[2].value = "";
    

}

function addTagHandler(json){
  if(json.error){
    let tagForm = document.getElementsByClassName('new-tag');
    let error = document.createElement('a');
    error.classList.add('error');
    error.textContent = json.tagName + " Already exists!";
    tagForm[0][2].insertAdjacentElement('afterend',error);
    setTimeout(() => {
      error.remove();
    }, 3000);
  }
  else{
    let newTag = document.createElement('p');
    newTag.classList.add('tag');
    newTag.textContent = json.tagName;
    document.getElementsByClassName('tagList flex')[0].appendChild(newTag);
    window.location.reload();
    
  }
}
async function sendDeleteTagRequest(ev) {

  ev.preventDefault();
  const tagForms = ev.target.parentElement.parentElement;
    const id = tagForms.getAttribute('data-id');
    const type = tagForms.getAttribute('data-type');
    let tagElem = tagForms.children;
    let tagName= tagElem[1].value;
    let tagId= tagElem[2].value;
    const csrf = tagElem[0].value;
  let url = "";
  if(type == "project"){
    url = '/api/projects/' + id + '/' +'tags/' + 'delete/'+ tagId;
  }
  else if(type == "world"){
    url = '/api/worlds/' + id + '/' +'tags/' + 'delete/'+ tagId;
  }
  else if(type == "member"){
    url = '/api/members/' + id + '/' +'tags/' + 'delete/'+ tagId;
  }
  const response = fetch(url, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': csrf,
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  }).then(response => {
    if(response.ok){
      return response.json();
    }
    else{
      throw new Error('Response status not OK');
    }
  }).then(data => {
    deleteTagHandler(data);
  }).catch(error => console.error('Error fetching data:', error.message));
}
async function deleteTagHandler(json){
  let tag = document.querySelectorAll('div.tag p');
  [].forEach.call(tag, function(tag) {
    if(tag.textContent == json.tagName){
      tag.parentElement.remove();
    }
  });
}
async function sendRemoveMemberFromWorldRequest(ev) {
  ev.preventDefault();
  async function request(){
    let csrf = this.querySelector('input:first-child').value;
    let id = this.querySelector('input.id').value;
    let username = this.querySelector('input.username').value;
    url = `/api/worlds/${id}/${username}`;
    const response = await fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      }
    }).then(response => {
      if(response.ok){
        return response.json();
      }
      else{
        throw new Error('Response status not OK');
      }
    }).then(data => {
      removeMemberFromThingHandler(data);
    }).catch(error => console.error('Error fetching data:', error.message));
  }
  
  confirmationAlert("Are you sure you want to remove this member from this world?","", "Member removed from this world!", "Bye bye!", "Remove them", request.bind(this),0);
  
}

async function sendRemoveMemberFromProjectRequest(ev) {
  ev.preventDefault();
  async function request(){
    let csrf = this.querySelector('input:first-child').value;
      let id = this.querySelector('input.id').value;
      let username = this.querySelector('input.username').value;
    
      url = `/api/projects/${id}/${username}`;
      const response = await fetch(url, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Content-Type': "application/json",
          'Accept': 'application/json',
          "X-Requested-With": "XMLHttpRequest"
        }
      }).then(response => {
        if(response.ok){
          return response.json();
        }
        else{
          throw new Error('Response status not OK');
        }
      }).then(data => {
        removeMemberFromThingHandler(data);
      }).catch(error => console.error('Error fetching data:', error.message));
  }
  confirmationAlert("Are you sure you want to remove this member from this project?","", "Member removed from this project!", "Bye bye!", "Remove them", request.bind(this),0);
  
}

function removeMemberFromThingHandler(data) {
  let element = document.querySelectorAll('ul.members [data-id="' + data.member_id + '"]');
  [].forEach.call(element, function(member) {
    member.remove();
  });
}


async function sendShowNotificationsRequest(ev) {
  
  if(ev != null){
    ev.preventDefault();
    }
  const url = '/api/notifications';
  const response = await fetch(url, {
      method: 'GET', 
      headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
      },
  })
    .then(response =>{
          if(response.ok){
            return response.json();
          }
          else{
            throw new Error('Response status not OK');
          }
    })
    .then(data => {
        ShowNotificationsHandler(data,ev);
    })
    .catch(error => console.error('Error fetching data:', error));

}

async function closeNotification(ev) {
  ev.preventDefault();
  const container = this.closest('div.notification');

  url = this.href;

  const response = await fetch(url, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Content-Type': "application/json",
      'Accept': 'application/json',
    }
  });

  const json = await response.json();

  if (response.ok) container.remove();
}

async function sendRequestAccept(ev) {
  ev.preventDefault();
  const container = this.closest('div');

  url = this.href;

  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Content-Type': "application/json",
      'Accept': 'application/json',
    }
  });

  const json = await response.json();

  if (response.ok) container.remove();
}

function ShowNotificationsHandler(json,ev){
  sessionStorage.setItem('showDot', 'false');
  showRedDot();

  let popup = document.getElementById("notificationList");
  const notificationPopup = document.getElementById('notificationArea');
  let notifications = json.notifications;
  popup.innerHTML = "";
  for(let notification of notifications){    
    let notificationText = document.createElement('h3');
    notificationText.classList.add('text-white', 'h-fit', 'break-words'); 
    let notificationDate= document.createElement('p');
    notificationDate.classList.add('text-white');
    const notificationCloser = document.createElement('a');
    notificationCloser.href = `/api/notifications/${notification.id}`;
    notificationCloser.innerHTML = '&times;';
    notificationCloser.classList.add('text-white');
    notificationCloser.addEventListener('click', closeNotification);
    let notificationContainer = document.createElement('div');
    let notificationTop = document.createElement('div');
    const colors = {
      'High': 'bg-darkRed',
      'Medium': 'bg-orange',
      'Low': 'bg-white/30'
    };
    notificationContainer.classList.add('notification', 'm-2', 'px-3', 'py-1', 'rounded', colors[notification.level]);
    notificationTop.classList.add('flex', 'justify-between', 'items-center');

    notificationText.textContent = notification.text;
    notificationDate.textContent = notification.date_;
    notificationTop.appendChild(notificationDate);
    notificationTop.appendChild(notificationCloser);
    notificationContainer.appendChild(notificationTop);
    notificationContainer.appendChild(notificationText);
    
    popup.appendChild(notificationContainer);

    if (notification.is_request) {
      const requestAccepter = document.createElement('a');
      const requestDenier = document.createElement('a');
      requestAccepter.classList.add('button');
      requestDenier.classList.add('button');
      requestAccepter.href = `/api/accept/${notification.id}`;
      requestDenier.href = `/api/notifications/${notification.id}`;
      requestAccepter.innerHTML = "&#10003;";
      requestDenier.innerHTML = "&#10005;";
      requestAccepter.addEventListener('click', sendRequestAccept);
      requestDenier.addEventListener('click', closeNotification);
      const requestButtons = document.createElement('nav');
      requestButtons.classList.add('flex', 'justify-center');
      requestButtons.appendChild(requestAccepter);
      requestButtons.appendChild(requestDenier);
      notificationContainer.appendChild(requestButtons);
    }

    if (popup.firstChild === null) {
      popup.appendChild(notificationContainer);
    } else {
      popup.insertBefore(notificationContainer, popup.firstChild);
    }
  }
  if(ev != null){
    notificationPopup.classList.toggle('hidden'); 
  }
}




async function sendAssignAdminToWorldRequest(ev) {
  ev.preventDefault();
  async function request(){
    let csrf = this.querySelector('input:first-child').value;
    let id = this.querySelector('input.id').value;
    let username = this.querySelector('input.username').value;
    let url = '/api/worlds/' + id + '/assign';  
    const response = await fetch(url, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({username: username})
    }).then(response => {
      if(response.ok){
        return response.json();
      }
      else{
        throw new Error('Response status not OK');
      }
    }).then(data => {
      assignAdminToWorldHandler(data);
    }).catch(error => console.error('Error fetching data:', error.message));
  }
  confirmationAlert("Are you sure you want to promote this member to World Admin?","", "Member promoted to World Admin!", "", "Promote them", request.bind(this),1000);
  

}

function assignAdminToWorldHandler(data) {  
  window.location.reload();
}


async function sendDemoteAdminFromWorldRequest(ev) {
  ev.preventDefault();
  async function request(){
    let csrf = this.querySelector('input:first-child').value;
    let id = this.querySelector('input.id').value;
    let username = this.querySelector('input.username').value;
    let url = '/api/worlds/' + id + '/demote';
    console.log(username);
    const response = await fetch(url, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({username: username})
    }).then(response => {
      if(response.ok){
        return response.json();
      }
      else{
        throw new Error('Response status not OK');
      }
    }).then(data => {
      demoteAdminToWorldHandler(data);
    }).catch(error => console.error('Error fetching data:', error.message));
  }
  confirmationAlert("Are you sure you want to demote this member from World Admin?","", "Member demoted from World Admin!", "They became a peasant again.", "Demote them", request.bind(this),1000);

}

function demoteAdminToWorldHandler(data) {
  window.location.reload();
}


async function sendAssignProjectLeaderRequest(ev) {
  ev.preventDefault();
  
  async function request(){
    let csrf = this.querySelector('input:first-child').value;
    let id = this.querySelector('input.id').value;
    let username = this.querySelector('input.username').value;
    let url = '/api/projects/' + id + '/assign';
    console.log(username);
    const response = await fetch(url, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({username: username})
    }).then(response => {
      if(response.ok){
        return response.json();
      }
      else{
        throw new Error('Response status not OK');
      }
    }).then(data => {
      assignProjectLeaderHandler(data);
    }).catch(error => console.error('Error fetching data:', error.message));
  }
  
  confirmationAlert("Are you sure you want to promote this member to Project Leader?","", "Member promoted to Project Leader!", "", "Promote them", request.bind(this),1000);
  
}

function assignProjectLeaderHandler(data) {  
  window.location.reload();
}

async function sendDemoteProjectLeaderRequest(ev) {
  ev.preventDefault();
  async function request(){
    let csrf = this.querySelector('input:first-child').value;
    let id = this.querySelector('input.id').value;
    let username = this.querySelector('input.username').value;
    let url = '/api/projects/' + id + '/demote';
    console.log(username);
    const response = await fetch(url, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({username: username})
    }).then(response => {
      if(response.ok){
        return response.json();
      }
      else{
        throw new Error('Response status not OK');
      }
    }).then(data => {
      demoteProjectLeaderHandler(data);
    }).catch(error => console.error('Error fetching data:', error.message));
  }
  confirmationAlert("Are you sure you want to demote this member from Project Leader?","", "Member demoted from Project Leader!", "They became a peasant again.", "Demote them", request.bind(this),1000);
  

  
}


  async function sendFavoriteRequest(event) {
    event.preventDefault();

    const id = this.querySelector('form#favorite input.id').value;
    const csrf = this.querySelector('form#favorite input:first-child').value;
    const type = this.querySelector('form#favorite input.type').value;

    const response = await fetch('/api/' + type + '/' + id + '/favorite', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': "application/json",
        'Accept': 'application/json',
        "X-Requested-With": "XMLHttpRequest"
      }
    });

    const json = await response.json();

    if (response.status !== 500) favoriteHandler(json);
}
function demoteProjectLeaderHandler(data) {
  if(data.error){
    console.log(datal.message);
  }
  window.location.reload();
}

  function favoriteHandler(json) {
    const button = document.querySelector('form#favorite button');
    if (json.favorite) {
      button.innerHTML = "&#9733";
    } else {
      button.innerHTML = "&#9734";
    }
  }

  function sendItemUpdateRequest() {
    let item = this.closest('li.item');
    let id = item.getAttribute('data-id');
    let checked = item.querySelector('input[type=checkbox]').checked;
  
    sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
  }
  
  function sendDeleteItemRequest() {
    let id = this.closest('li.item').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
  }
  
  function sendCreateItemRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
    let description = this.querySelector('input[name=description]').value;
  
    if (description != '')
      sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);
  
    event.preventDefault();
  }
  
  function sendDeleteCardRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
  }
  
  function sendCreateCardRequest(event) {
    let name = this.querySelector('input[name=name]').value;
  
    if (name != '')
      sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);
  
    event.preventDefault();
  }
  
  function itemUpdatedHandler() {
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    let input = element.querySelector('input[type=checkbox]');
    element.checked = item.done == "true";
  }
  
  function itemAddedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
  
    // Create the new item
    let new_item = createItem(item);
  
    // Insert the new item
    let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);
  
    // Reset the new item form
    form.querySelector('[type=text]').value="";
  }
  
  function itemDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    element.remove();
  }
  
  function cardDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
    let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
    article.remove();
  }
  
  function cardAddedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
  
    // Create the new card
    let new_card = createCard(card);
  
    // Reset the new card input
    let form = document.querySelector('article.card form.new_card');
    form.querySelector('[type=text]').value="";
  
    // Insert the new card
    let article = form.parentElement;
    let section = article.parentElement;
    section.insertBefore(new_card, article);
  
    // Focus on adding an item to the new card
    new_card.querySelector('[type=text]').focus();
  }
  
  function createCard(card) {
    let new_card = document.createElement('article');
    new_card.classList.add('card');
    new_card.setAttribute('data-id', card.id);
    new_card.innerHTML = `
  
    <header>
      <h2><a href="cards/${card.id}">${card.name}</a></h2>
      <a href="#" class="delete">&#10761;</a>
    </header>
    <ul></ul>
    <form class="new_item">
      <input name="description" type="text">
    </form>`;
  
    let creator = new_card.querySelector('form.new_item');
    creator.addEventListener('submit', sendCreateItemRequest);
  
    let deleter = new_card.querySelector('header a.delete');
    deleter.addEventListener('click', sendDeleteCardRequest);
  
    return new_card;
  }
  
  function createItem(item) {
    let new_item = document.createElement('li');
    new_item.classList.add('item');
    new_item.setAttribute('data-id', item.id);
    new_item.innerHTML = `
    <label>
      <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
    </label>
    `;
  
    new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
    new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);
  
    return new_item;
  }
  

  
  // Close the pop-up
  function closeSearchedTaskPopup() {
    document.getElementById('popupContainer').classList.add('hidden');
 }
async function sendClearNotificationsRequest(ev){
  ev.preventDefault();
  const url = '/api/notifications';
  const response = await fetch(url, {
      method: 'DELETE', 
      headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
  })
    .then(response =>{
          if(response.ok){
            return response.json();
          }
          else{
            throw new Error('Response status not OK');
          }
    })
    .then(data => {
        clearNotificationsHandler(data);
    })
    .catch(error => console.error('Error fetching data:', error));
  
}
function clearNotificationsHandler(json){
  let popup = document.getElementById("notificationList");
  popup.innerHTML = "";
  let notificationContainer = document.createElement('div');
  notificationContainer.classList.add('flex', 'flex-col', 'py-2','px-10', 'm-2', 'rounded-lg', 'bg-white');
  let notificationText = document.createElement('p');
  notificationText.classList.add('text-black');
  notificationText.textContent = json.message;
  notificationContainer.appendChild(notificationText);
  popup.appendChild(notificationContainer);

}
 // Get member belongings in ajax on every page load for pusher notifications
async function getMemberBelongingsRequest(ev){
  ev.preventDefault();
  const url = '/api/allBelongings';
    const response = await fetch(url, {
        method: 'GET', 
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
      .then(response =>{
            if(response.ok){
              return response.json();
            }
            else{
              throw new Error('Response status not OK');
            }
      })
      .then(data => {
          getIdsHandler(data);
      })
      .catch(error => console.error('Error fetching data:', error));

}

function getIdsHandler(json){
  let project_ids = json.projects_ids;
  let world_ids = json.worlds_ids;
  pusherNotifications(project_ids, world_ids);
}



function showRedDot(){
  let showDot= sessionStorage.getItem('showDot') == 'true';
  if(showDot){
    document.getElementById('redDot').classList.remove('hidden');
  }
  else{
    document.getElementById('redDot').classList.add('hidden');
  }
}

// Pusher notifications
function pusherNotifications(projectContainer, worldContainer){
  
  Pusher.logToConsole = false;
  
  const pusher = new Pusher("11f57573d00ddf0021b9", {
    cluster: "eu",
    encrypted: true
  });

  function bindEvent(channel, eventName, callback) {
    channel.bind(eventName, callback);
  } 

  for (let i = 0; i < worldContainer.length; i++) { 
    const world_id = worldContainer[i];
    const channelWorld = pusher.subscribe('World' + world_id);
    bindEvent(channelWorld, 'ProjectNotification', function(data){
      let showDot = sessionStorage.getItem('showDot') == 'true';
      if(!showDot){
        sessionStorage.setItem('showDot', 'true'); 
        showRedDot();
      }
    });
    bindEvent(channelWorld, 'WorldNotification', function(data){
      let showDot = sessionStorage.getItem('showDot') == 'true';
      if(!showDot){
        sessionStorage.setItem('showDot', 'true');
      }
    });
    bindEvent(channelWorld,'TagNotification', function(data){
      let showDot = sessionStorage.getItem('showDot') == 'true';
      if(!showDot){
        sessionStorage.setItem('showDot', 'true');
      }
    });
  }

  for(let i = 0; i < projectContainer.length; i++){
    const project_id = projectContainer[i];
    const channelProject = pusher.subscribe('Project' + project_id);
    bindEvent(channelProject, 'TaskNotification', function(data){
      let showDot = sessionStorage.getItem('showDot') == 'true';
      if(!showDot){
        sessionStorage.setItem('showDot', 'true');
      }
      
    });
    bindEvent(channelProject,'TagNotification', function(data){
      let showDot = sessionStorage.getItem('showDot') == 'true';
      if(!showDot){
        sessionStorage.setItem('showDot', 'true');
      }
    });
  }
}


async function confirmationAlert(text,subtext,secondText,secondSubtext,yesButtonText, callback,callbackTimer){
  await Swal.fire({
    title: text,
    showConfirmButton: true,
    icon: "warning",
    showCancelButton: true,
    text: subtext,
    confirmButtonText: yesButtonText,
    showCancelButton: true,
    customClass:{
      popup: 'rounded-3xl',
      confirmButton: 'rounded-2xl bg-red',
      cancelButton: 'rounded-2xl',
    },
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title:secondText,
        text:secondSubtext,
        showConfirmButton:true,
        confirmButtonText: "OK",
        icon: "success",
        customClass:{
          popup: 'rounded-3xl',
          confirmButton: 'rounded-2xl bg-grey',
        },
      });
      if(callbackTimer != 0 && callbackTimer != null){
        setTimeout(() => {
          callback();
        }, callbackTimer);
      }
      else{
       callback();
      }
      
    }
  });
}
addEventListeners();
showRedDot();
function openSidebar() {
  console.log('hello');
  document.querySelector('#sidebar-text').click();
}
  
