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
      editor.querySelector('button').addEventListener('click', sendEditMemberRequest);
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

    let memberAdder = document.querySelector('form#add-member');
    if (memberAdder != null)
      memberAdder.addEventListener('submit', sendAddMemberRequest);

    let button = document.getElementById("createTagButton");
    if(button != null)
    button.addEventListener("submit", addTagRequest);
    
    let worldMemberAdder = document.querySelector('form#add-member-to-world');
    if (worldMemberAdder != null)
      worldMemberAdder.addEventListener('submit', sendAddMemberToWorld);

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
    
    let MemberAssigner = document.querySelector('form#assign-member');
    if (MemberAssigner != null)
      MemberAssigner.addEventListener('submit', sendAssignMemberRequest);
    
    let closePopup = document.getElementById('closePopUp');
    if(closePopup != null)
      closePopup.addEventListener('click', closeSearchedTaskPopup);
    
    let removeMemberFromWorlds = document.querySelectorAll('form#remove-member-world');
    if(removeMemberFromWorlds != null){
      removeMemberFromWorlds.forEach(removeMemberFromWorld => {
        removeMemberFromWorld.addEventListener('submit', sendRemoveMemberFromWorldRequest);
      });
    }

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
    const ul = document.querySelector('ul.members');
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
    img.src = json.picture;
    
    h4.appendChild(a);
    header.appendChild(img);
    header.appendChild(h4);

    member.appendChild(header);

    const removeForm = document.createElement('form');
    removeForm.id= 'remove-member-project';
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    removeForm.innerHTML = `
      <input type="hidden" name="_token" value="${csrfToken}">
      <input type="hidden" class="id" value="${json.project_id}">
      <input type="hidden" class="username" value="${json.username}">
      <input type="submit" value="X">
    `;

    removeForm.addEventListener('submit', sendRemoveMemberFromProjectRequest);

    ul.appendChild(member);
    ul.appendChild(removeForm);
   
  }

  function addMemberWorldHandler(json) {
    const ul = document.querySelector('ul.members');
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
    header.classList.add('row');
    const img = document.createElement('img');
    img.classList.add('small');
    const h4 = document.createElement('h4');
    const a = document.createElement('a');
    a.href = '/members/' + json.username;
    a.textContent = json.username;
    img.src = json.picture;
    
    h4.appendChild(a);
    header.appendChild(img);
    header.appendChild(h4);

    member.appendChild(header);

    const removeForm = document.createElement('form');
    removeForm.id= 'remove-member-world';
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    removeForm.innerHTML = `
      <input type="hidden" name="_token" value="${csrfToken}">
      <input type="hidden" class="id" name="id" value="${json.world_id}">
      <input type="hidden" class="username" name="username" value="${json.username}">
      <input type="submit" value="X">
    `;

    member.appendChild(removeForm);
    removeForm.addEventListener('submit', sendRemoveMemberFromWorldRequest);

    ul.appendChild(member);
   
  }

  async function sendAddMemberToWorld(event){
      event.preventDefault();

      const username= this.querySelector('input.username').value;
      const id = this.querySelector('input.id').value;
      const csrf = this.querySelector('input:first-child').value;
      const type = this.querySelector('select.type').value;

      const response = await fetch('/api/worlds/' + id + '/' + username, {
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

      if (response.status !== 500) addMemberWorldHandler(json)
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

  function sendCreateTaskRequest() {
    let form = this.closest('form.new-task');
    let title = form.querySelector('input.title').value;
    let description = form.querySelector('input.description').value;
    let due_at = form.querySelector('input.due_at').value;
    let effort = form.querySelector('input.effort').value;
    let priority = form.querySelector('select.priority').value;
    let project_id = form.querySelector('input.project_id').value;

    sendAjaxRequest('put', '/api/tasks/', {title: title, description: description, due_at: due_at, effort: effort, priority: priority, project_id: project_id}, taskAddedHandler);
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
    console.log(tagForms);
    let tagElem = tagForms[0].children;
    let tagElemName= tagElem[1].value;
    let tagName = tagElemName.replace(/\s/g, '');
    const csrf = tagElem[0].value;
    console.log(tagName)
    console.log('/api/projects/' + id + '/' +'tags/create');
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
      console.log(tagElemName)
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
    document.getElementsByClassName('tagList').appendChild(newTag);
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
    removeMemberFromWorldHandler(data);
  }).catch(error => console.error('Error fetching data:', error.message));
}

function removeMemberFromWorldHandler(data) {
  let element = document.querySelector('ul.members [data-id="' + data.member_id + '"]');
  element.remove();
  let form = document.querySelector('form#remove-member-world [data-id="' + data.member_id + '"]');
  form.remove();
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
    removeMemberFromProjectHandler(data);
  }).catch(error => console.error('Error fetching data:', error.message));
}

function removeMemberFromProjectHandler(data) {
  let element = document.querySelector('ul.members [data-id="' + data.member_id + '"]');
  element.remove();
  let form = document.querySelector('form#remove-member-project [data-id="' + data.member_id + '"]');
  form.remove();
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
  
  addEventListeners();
  
  // Close the pop-up
  function closeSearchedTaskPopup() {
    document.getElementById('popupContainer').classList.add('hidden');
 }

function openSidebar() {
  console.log('hello');
  document.querySelector('#sidebar-text').click();
}
  