<?php
session_start();
include_once('db.php');
include_once('pagination.php');
// Admin authorizate
if ($_POST['action'] == 'admin_auth') {
    $login = $_POST['data'][0]['value'];
    $password = $_POST['data'][1]['value'];

    $sql = 'SELECT * FROM admin WHERE login = :login AND password = :password';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login' => $login, 'password' => $password]);
    $result = $stmt->fetch();

    if ($result) {
        $_SESSION['login'] = $result['login'];
        echo json_encode($result);
    } else {
        echo json_encode('Пользователь не найден');
    }
}

// Suggest form
if ($_POST['action'] == 'suggest_joke') {
    $category = $_POST['data'][0]['value'];
    $title = $_POST['data'][1]['value'];
    $body = $_POST['data'][2]['value'];

    if ($title == '' || $body == '') {
        echo json_encode('Пустые данные');
        return;
    }

    $query = $pdo->query("SELECT category.id_category FROM category WHERE name = '$category'");
    $result = $query->fetch();

    $query = 'INSERT INTO suggest (title, body, category) VALUES (:title, :body, :category)';
    $stmt = $pdo->prepare($query);
    $stmt->execute(['title' => $title, 'body' => $body, 'category' => $result['id_category']]);

    echo json_encode('Анекдот отправлен на модерацию');

}

// Add joke
if ($_GET['action'] == 'add_joke') {
    $id = $_GET['data'];

    $query = ('
        START TRANSACTION;
        INSERT INTO joke (title, body, category)
        SELECT suggest.title, suggest.body, suggest.category FROM suggest WHERE id_suggest = '. $id .' LIMIT 1;
        DELETE FROM suggest WHERE id_suggest = '. $id .';
        COMMIT;
    ');
    $pdo->exec($query);
    echo json_encode('Анекдот прошел модерацию');
}

// Ignore joke
if ($_GET['action'] == 'ignore_joke') {
    $id = $_GET['data'];

    $query = ('DELETE FROM suggest WHERE id_suggest = ' . $id);
    $pdo->exec($query);
    echo json_encode('Анекдот удален');
}

// Update joke list
if ($_GET['action'] == 'update_joke_list') {

    $category = $_GET['data'];

    if ($category == 'Все') {
        $query = "SELECT joke.title, joke.body, category.name FROM joke
                    INNER JOIN category ON category = id_category";
    } else {
        $query = "SELECT joke.title, joke.body, category.name FROM joke
                    INNER JOIN category ON category = id_category WHERE category.name = '$category'";
    }
    $newPagination = pagination($query, $pdo);
    $query = $query . $newPagination['limit'];

    $query = $pdo->query($query);
    echo json_encode([$query->fetchAll(), $newPagination['hrefs']]);
}
