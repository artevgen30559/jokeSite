// Load joke list
$(document).ready(function() {
    $.ajax({
        url: 'server.php',
        method: 'GET',
        dataType: 'JSON',
        data: {action: 'update_joke_list', data: 'Все'},
        success: function(response) {
            console.log(response);
            update_joke_list(response);
        }
    });
});

// FORM handler
$('form').submit(function(e) {
    e.preventDefault();
    let method  = $(e.target).attr('method'),
        action  = $(e.target).attr('action'),
        data    = $(e.target).serializeArray();

    $.ajax({
        url: 'server.php',
        method: method,
        dataType: 'JSON',
        data: {
            action: action,
            data: data
        },
        success: function(response) {
            window[action](response);
        }
    });
});

// SELECT handler
$('select.update').change(function(e) {
    let data    = $(this).val(),
        action  = $(this).attr('action');

    $.ajax({
        url: 'server.php',
        method: 'GET',
        dataType: 'JSON',
        data: {action: action, data: data},
        success: function(response) {
            window[action](response);
        }
    });
});

// BUTTON handler
$('button[type="button"]').click(function(e) {
    e.preventDefault();
    let action  = $(e.target).attr('action'),
        data    = $(e.target).attr('data');

    $.ajax({
        url: 'server.php',
        method: 'GET',
        dataType: 'JSON',
        data: {action: action, data: data},
        success: function(response) {
            alert(response);
        }
    });
});


// Update joke list
function update_joke_list(response) {
    $('.joke-list .list').empty();
    for(item of response[0]) {
        $('.joke-list .list').append(`
            <div class="joke">
                <h3>`+item['title']+`</h3>
                <p>`+item['body']+`</p>
                <p>Категория: `+item['name']+`</p>
            </div>
        `);
    }
    for(item of response[1]) {
        $('.joke-list .pagination').append(item);
    }
}
// Authorization admin_auth
function admin_auth(data) {
    (data == 'Пользователь не найден') ? alert(data) : location.href = 'admin.php';
}

// Suggest Form
function suggest_joke(data) {
    alert(data);
}
