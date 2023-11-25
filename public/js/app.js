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

    let bigboxes = document.querySelectorAll('ul.big-box');
    [].forEach.call(bigboxes, function(bigbox) {
      bigbox.addEventListener("drop", bigBoxDropHandler);
      bigbox.addEventListener("dragover", bigBoxDragOverHandler);
    })

    let memberAdder = document.querySelector('form#add-member');
    if (memberAdder != null)
      memberAdder.addEventListener('submit', sendAddMemberRequest);

    let button = document.getElementById("createTagButton");
    if(button != null)
    button.addEventListener("click", addTagRequest);
    
    let worldMemberAdder = document.querySelector('form#add-member-to-world');
    if (worldMemberAdder != null)
      worldMemberAdder.addEventListener('submit', sendAddMemberToWorld);

    let taskResults = document.getElementById('openPopupButton');
    if(taskResults != null)
      taskResults.addEventListener('click', function() {
        if(document.getElementById('popupContainer').style.display == 'block'){
          document.getElementById('popupContainer').style.display = 'none'
        }
        else{
          document.getElementById('popupContainer').style.display = 'block';
        }
      });

    let searchTaskButton = document.getElementById('searchTaskButton');
    let searchTaskForm = document.getElementsByClassName('search-task')[0];
    if(searchTaskButton != null){
      searchTaskButton.addEventListener('click', searchTaskRequest);
      searchTaskForm.addEventListener('submit', searchTaskRequest);
    }

    let searchProjectButton = document.getElementById('searchProjectButton');
    let searchProjectForm = document.getElementsByClassName('search-project')[0];
    if(searchProjectButton != null)
    {
      searchProjectButton.addEventListener('click', searchProjectRequest);
      searchProjectForm.addEventListener('submit', searchProjectRequest);

    }
    
    let MemberAssigner = document.querySelector('form#assign-member');
    if (MemberAssigner != null)
      MemberAssigner.addEventListener('submit', sendAssignMemberRequest);
    
    let closePopup = document.getElementById('closePopUp');
    if(closePopup != null)
      closePopup.addEventListener('click', closeSearchedTaskPopup);
    
    let leaveWorld = document.querySelectorAll('form#leave-world');
    if(leaveWorld != null)
      leaveWorld.addEventListener('submit', sendLeaveWorldRequest);
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
    const status = box.parentElement.querySelector('h4').textContent;

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

      if (response.status !== 500) addMemberHandler(json)
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
    let popup = document.getElementsByClassName('popup-content')[0];
    popup.innerHTML = "";
    let newUl= document.createElement('ul');
    newUl.setAttribute('class', 'TaskList');

    let tasks = JSON.parse(json.tasks);
    
    for (let task of tasks) {
      let newSpan = document.createElement('span');
      let newTitle = document.createElement('p');
      let newDescription = document.createElement('p');
      let newDueAt = document.createElement('p');
      let newEffort = document.createElement('p');
      let newPriority = document.createElement('p'); 
      let newStatus = document.createElement('p');
    

      newTitle.setAttribute('href', '/tasks/' + task.id);
      newTitle.textContent = task.title;
      newDescription.textContent = task.description;
      newDueAt.textContent = task.due_at;
      newEffort.textContent = task.effort; 
      newPriority.textContent = task.priority;
      newStatus.textContent = task.status; 
      newSpan.appendChild(newTitle);
      newSpan.appendChild(newDescription); 
      newSpan.appendChild(newDueAt);
      newSpan.appendChild(newStatus);  
      newSpan.appendChild(newEffort);
      newSpan.appendChild(newPriority);
      newUl.appendChild(newSpan);
    };
    popup.appendChild(newUl);
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
  let popup = document.getElementsByClassName('popup-content')[0];
  popup.innerHTML = "";
  let newUl= document.createElement('ul');
  
  newUl.setAttribute('class', 'ProjectList');
  let projects = JSON.parse(json.projects);
  
  for (let project of projects) {
    let newSpan = document.createElement('span');
    let newTitle = document.createElement('p');
    let newDescription = document.createElement('p');
    let newPicture = document.createElement('img'); 
    let newStatus = document.createElement('p');


    newTitle.setAttribute('href', '/projects/' + project.id);
    newPicture.setAttribute('src', project.picture);
    newTitle.textContent = project.name;
    newDescription.textContent = project.description;
    newStatus.textContent = project.status;
    newSpan.appendChild(newPicture); 
    newSpan.appendChild(newTitle);
    newSpan.appendChild(newDescription); 
    newSpan.appendChild(newStatus);  
    
    newUl.appendChild(newSpan);
  };
  popup.appendChild(newUl);
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
    let newTag = document.createElement('span');

  // Set class attribute for the new span element
  newTag.setAttribute('class', 'badge badge-secondary');

  // Set text content for the new span element
  newTag.textContent = json.tagName;

  // Assuming you want to append to the first element with the 'tagList' class
  let tagListElement = document.getElementsByClassName('tagList');

  // Append the new span element to the tag list element
  tagListElement[0].appendChild(newTag);
  }
  
}

async function sendLeaveWorldRequest() {
  let id = this.querySelector('input.world_id').value;
  let csrf = this.querySelector('input:first-child').value;
  let username = this.querySelector('input.username').value;

  console.log('/api/worlds/' + id + '/' + username);
  const response = await fetch('/api/worlds/' + id + '/' + username, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': csrf,
      'Content-Type': "application/json",
      'Accept': 'application/json',
      "X-Requested-With": "XMLHttpRequest"
    },
    body: JSON.stringify({type: type})
  }).then(response =>{
    if(response.ok){
      return response.json();
    }
    else{
      throw new Error('Response status not OK');
    }
  }).then(data => {
    leaveWorldHandler(data);
  }).catch(error => console.error('Error fetching data:', error));

  const json = await response.json();

  if (response.status !== 500) leaveWorldHandler(json)
}

function leaveWorldHandler() {
  let element = document.querySelector('ul.members [data-id="' + id + '"]');
  element.remove();
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
    document.getElementById('popupContainer').style.display = 'none';
 }


  