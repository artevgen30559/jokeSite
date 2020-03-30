<?php
    session_start();
    $_SESSION['page'] = $_GET['page'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Анекдоты</title>
    <link rel="stylesheet" href="/style.css">
  </head>
  <body>
      <div class="content">
          <side-bar>
              <h2>Авторизация для админов</h2>
              <form class="admin-auth" action="admin_auth" method="POST">
                  <input type="text" name="login" placeholder="Логин">
                  <input type="password" placeholder="Пароль" name="password">
                  <button type="submit" name="enter">Войти</button>
                  <a href="admin.php">Перейти в Admin панель управления</a>
              </form>
              <h2>Предложить анекдот</h2>
              <form class="suggest-joke" action="suggest_joke" method="POST">
                  <select name="joke-category">
                      <option value="Актуальное">Актуальное</option>
                      <option value="Про животных">Про животных</option>
                      <option value="Про знаменитостей">Про знаменитостей</option>
                  </select>
                  <input type="text" placeholder="Заголовок" name="joke-title">
                  <textarea name="joke-body" rows="8" cols="80" placeholder="Текст анекдота"></textarea>
                  <button type="submit" name="joke-send">Предложить анекдот</button>
              </form>
          </side-bar>
          <div class="joke-list">
              <h2>Список анекдотов</h2>
              Выберите категорию:
              <select name="joke-category" action="update_joke_list" class="update">
                  <option value="Все">Все</option>
                  <option value="Актуальное">Актуальное</option>
                  <option value="Про животных">Про животных</option>
                  <option value="Про знаменитостей">Про знаменитостей</option>
              </select>
              <div class="list"></div>
              <div class="pagination">

              </div>
          </div>
      </div>
  </body>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="handler.js"></script>


</html>
