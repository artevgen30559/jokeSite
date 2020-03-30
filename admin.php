<?php
    session_start();
    if ($_SESSION['login'] == null) {
        header('Location: index.php');
    }
    include_once('db.php');
    $query = $pdo->query('SELECT suggest.title, suggest.body, category.name, suggest.id_suggest FROM suggest
                        INNER JOIN category ON category = id_category');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Admin панель</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="suggest-list">
            <h2 style="text-align: center;">Анекдоты от пользователей</h2>
            <hr>
            <div class="list">
                <?php while($row = $query->fetch()) { ?>
                    <div class="joke">
                        <h3><?php echo $row['title'] ?></h3>
                        <p><?php echo $row['body'] ?></p>
                        <p>Категория: <?php echo $row['name'] ?></p>
                        <button type="button" class="add_btn" action="add_joke" data="<?php echo $row['id_suggest']; ?>">Смешно</button>
                        <button type="button" class="ignore_btn" action="ignore_joke" data="<?php echo $row['id_suggest']; ?>">Не смешно</button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="handler.js"></script>
</html>
