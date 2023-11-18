
 function addTagHandler(){
    var button = document.getElementById("createTagButton");
    // Add an event listener to the button
    button.addEventListener("click", function() {
        // This function will be executed when the button is clicked
        console.log("Button pressed!");
    });
}

/*async function addTag() {
    e.preventDefault();
    const tag = document.getElementsByClassName('new-tag');
    var tagName= tag[2].value;
    const csrf = tag[0].value;

    console.log($tagName);
    const response = await fetch('/api/tags/create', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ type:type })
    });
    const data = await response.json();
    console.log(data);
    if (data.success) {
        tagName.value = '';
        newTag = document.createElement('span').setAttribute('class', 'badge badge-secondary');
        newtag.textContent = data.tagName;
        document.getElementsByClassName('tagList').appendChild(newTag);
    }
}*/