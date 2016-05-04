var input_name = document.getElementById('input-name'),
    form_addnew = document.getElementById('form-addnew'),
    table_tasks = document.getElementById('table-tasks');

loadAll();

// obsługa eventu wysłania formularza
form_addnew.addEventListener('submit', function (e) {
    var name = input_name.value;
    createTask(name);
    
    e.preventDefault();
    return false;
});

// załadowanie wszystkich tasków
function loadAll() {
    fetchival('/all').get().then(function (tasks) {
        var html = '';
        
        for (var i in tasks) {
            var id = tasks[i].id,
                done = tasks[i].done,
                name = tasks[i].name,
                time = tasks[i].date,
                action = '<a href="#" onclick="markTask('+id+')">odhacz</a> <a href="#" onclick="deleteTask('+id+')">usuń</a>';
                
            var date = new Date;
            date.setTime(time * 1000);
            
            var marked = done == 1 ? ' class="done"' : '';
            
            html += '<tr><td'+marked+'>'+name+'</td><td'+marked+'>'+date.toLocaleDateString()+'</td><td>'+action+'</td></tr>';
        }
        
        table_tasks.innerHTML = html;
    });
}

// utworzenie nowego taska
function createTask(name) {
    if (name.length < 3) {
        alert('Zbyt krótko, wysil się bardziej!');
        return;
    }
        
    fetchival('/create').post({
        name: name
    }).then(function (json) {
        loadAll();
        input_name.value = '';
    });
    
}

// usunięcie taska o podanym id
function deleteTask(id) {
    fetchival('/delete/'+id).get().then(function (response) {
        if (response.success)
            loadAll();
    });
}

// oznaczenie taska
function markTask(id) {
    fetchival('/change-status/' + id).get().then(function (response) {
        if (response.success)
            loadAll();
    });
}
