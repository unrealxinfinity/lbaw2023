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
    if(button != null)
    button.addEventListener("click", addTagRequest);
    
    let worldMemberAdder = document.querySelectorAll('form#invite-member');
    if (worldMemberAdder != null){
      [].forEach.call(worldMemberAdder, function(form) {
        form.addEventListener('submit', sendInviteMember);
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
    console.log(MemberAssigner);

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
    
      if (currentScroll > lastScrollTop) {
        // Scroll down
        document.querySelector('#navbar').classList.remove('translate-y-0');
        document.querySelector('#navbar').classList.add('-translate-y-full');
        document.querySelector('#show-menu').checked = false;
      } else {
        // Scroll up
        document.querySelector('#navbar').classList.remove('-translate-y-full');
        document.querySelector('#navbar').classList.add('translate-y-0');
      }
    
      lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    }, false);
    
      window.addEventListener('load',getMemberBelingingsRequest);
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

    let previewImg = document.querySelector('input#edit-img');
    if (previewImg != null) {
      previewImg.addEventListener('change', PreviewImageHandler);
    }

    let favouriter = document.querySelector('form#favorite');
    if (favouriter != null)
    favouriter.addEventListener('submit', sendFavoriteRequest);
  }
  
  function deleteAccountButton() {
    const text = prompt("Are you sure you want to delete your account? Type \"delete\" to confirm:");

    if (text != "delete") return;

    window.location.href = window.location.href + '/delete'
  }
  function deleteWorldButton(ev) {
    ev.preventDefault();
    const text = prompt("Are you sure you want to delete your world? Type \"delete\" to confirm:");
    if(text == "delete"){
      this.submit();
    };
    
    
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
    console.log(ev.target);
    console.log(ev.currentTarget);
    const data = ev.dataTransfer.getData("text/plain");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const box = ev.currentTarget;
    const status = box.querySelector('h2').textContent;

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
    console.log(ev.target.id);
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
    console.log(url);
  
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

    console.log('/api/projects/' + id + '/' + username);
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
      header.classList.add('flex', 'justify-start');
      const img = document.createElement('img');
      img.classList.add('h-fit', 'aspect-square', 'mx-1');
      const h4 = document.createElement('h4');
      const a = document.createElement('a');
      a.href = '/members/' + json.username;
      a.textContent = json.username;
      console.log(json.picture);
      img.src = json.picture;
      
      h4.appendChild(a);
      header.appendChild(img);
      header.appendChild(h4);
  
      member.appendChild(header);

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

      const div = document.createElement('div');
      div.classList.add("flex", "justify-between");
      div.appendChild(member);
      if (json.can_remove) {
      div.appendChild(removeForm);
      removeForm.addEventListener('submit', sendRemoveMemberFromProjectRequest);
      }
      let section = json.is_leader=='true'? ul.querySelector('#project-leaders'):ul.querySelector('#members'); 
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
        body: JSON.stringify({username: username, type: type})
      });

      const json = await response.json();

      if (response.status !== 500) inviteMemberHandler(json);
  }

  async function sendAssignMemberRequest(event) {
    event.preventDefault();
    const username = this.querySelector('input.username').value;
    const id = this.querySelector('input.id').value;
    const csrf = this.querySelector('input:first-child').value;
    
    console.log('/api/tasks/' + id + '/' + username);
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
    console.log("hello")    
    
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
    let div = document.createElement('div');
    div.classList.add('bg-white', 'text-black', 'p-1', 'm-1', 'rounded');
    let outer_title = document.createElement('h2');
    let inner_title = document.createElement('a');
    let desc = document.createElement('p');

    let tasks = JSON.parse(json.tasks);
    for (task of tasks) {
      inner_title.setAttribute('href', '/tasks/' + task.id);
      inner_title.textContent = task.title;
      desc.textContent = task.description;
      outer_title.appendChild(inner_title);
      div.appendChild(outer_title);
      div.appendChild(desc); 
      popup.appendChild(div);
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
    let order = searchProjectElems[3].value;
    let url = '/api/worlds/'+ id +'/projects?search=' + searchedProject + '&order=' + order;
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
  let outer_div = document.createElement('div');
  outer_div.classList.add('bg-white', 'text-black', 'p-1', 'm-1', 'rounded', 'flex');
  let img = document.createElement('img');
  img.classList.add('h-16', 'aspect-square', 'mt-5', 'ml-5');
  let inner_div = document.createElement('div');
  inner_div.classList.add('flex', 'flex-col');
  let outer_title = document.createElement('h1');
  outer_title.classList.add('text-black');
  let inner_title = document.createElement('a');
  let desc = document.createElement('h2');
  desc.classList.add('ml-3', 'mb-5');

  let projects = JSON.parse(json.projects);
  for (project of projects) {
    inner_title.setAttribute('href', '/projects/' + project.id);
    img.setAttribute('src', project.picture);
    inner_title.textContent = project.name;
    desc.textContent = project.description;
    outer_title.appendChild(inner_title);
    inner_div.appendChild(outer_title);
    inner_div.appendChild(desc);
    outer_div.appendChild(img);
    outer_div.appendChild(inner_div);
    popup.appendChild(outer_div);
  };
  document.getElementById('popupContainer').classList.remove('hidden');
}

  async function addTagRequest() {

    const tagForms = document.getElementsByClassName('new-tag');
    const id = tagForms[0].getAttribute('data-id');
    let tagElem = tagForms[0].children;
    let tagName= tagElem[1].value;
    const csrf = tagElem[0].value;
    const response = await fetch('/api/projects/' + id + '/' +'tags/create', {
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
      tagElem[1].value = "";
    

}

function addTagHandler(json){
  if(json.error){
    console.log('Already exists entry');
  }
  else{
    let newTag = document.createElement('p');
    newTag.classList.add('tag');
    newTag.textContent = json.tagName;
    document.getElementsByClassName('tagList flex')[0].appendChild(newTag);
  }
  
}

async function sendRemoveMemberFromWorldRequest(ev) {
  ev.preventDefault();
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

async function sendRemoveMemberFromProjectRequest(ev) {
  ev.preventDefault();
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
  const container = this.parentElement;

  url = '/test';

  const response = await fetch(url, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Content-Type': "application/json",
      'Accept': 'application/json',
    }
  });

  const json = await response.json()

  if (response.ok) container.remove()
}

function ShowNotificationsHandler(json,ev){
  let popup = document.getElementById("notificationList");
  const notificationPopup = document.getElementById('notificationArea');

  let notifications = json.notifications;
  popup.innerHTML = "";
  for(let notification of notifications){    
    let notificationText = document.createElement('p');
    notificationText.classList.add('text-black'); 
    let notificationPriority = document.createElement('p');
    notificationPriority.classList.add('text-black');
    let notificationDate= document.createElement('p');
    notificationDate.classList.add('text-black');
    const notificationCloser = document.createElement('a');
    notificationCloser.href = `/notifications/${notification.id}`;
    notificationCloser.textContent = 'X';
    notificationCloser.classList.add('absolute', 'top-0', 'left-0', 'text-black');
    notificationCloser.addEventListener('click', closeNotification)
    let notificationContainer = document.createElement('div');
    notificationContainer.classList.add('flex', 'flex-col', 'py-2','px-10', 'm-4', 'rounded-lg', 'bg-white', 'relative');
    notificationText.textContent = notification.text;
    notificationPriority.textContent = notification.level;
    notificationDate.textContent = notification.date_;
    notificationContainer.appendChild(notificationText);
    notificationContainer.appendChild(notificationPriority);
    notificationContainer.appendChild(notificationDate);
    notificationContainer.appendChild(notificationCloser);
    popup.appendChild(notificationContainer);
  }
  if(ev != null){
    notificationPopup.classList.toggle('hidden'); 
  }
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
async function getMemberBelingingsRequest(ev){
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
        alert(JSON.stringify(data.message));
        sendShowNotificationsRequest();
        
      });
      bindEvent(channelWorld, 'WorldNotification', function(data){
        alert(JSON.stringify(data.message));
        sendShowNotificationsRequest();
      });
    }
    for(let i = 0; i < projectContainer.length; i++){
      const project_id = projectContainer[i];
      const channelProject = pusher.subscribe('Project' + project_id);
      bindEvent(channelProject, 'TaskNotification', function(data){
        alert(JSON.stringify(data.message));
        sendShowNotificationsRequest();
      });

      bindEvent(channelProject, 'TagNotification', function(data){
        alert(JSON.stringify(data.message));
        sendShowNotificationsRequest();
      });
    }
  
  
}

addEventListeners();

function openSidebar() {
  console.log('hello');
  document.querySelector('#sidebar-text').click();
}
  
