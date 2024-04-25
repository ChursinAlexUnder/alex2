<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;
if (session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    ?>
      <form action="" method="post">
        <div>Пользователь уже авторизован</div>
        <input type="submit" name="logout" value="Выход"/>
      </form>
    <?php
      if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: ./');
        exit();
      }
  }
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="" method="post">
  <input name="login" />
  <input name="pass" />
  <input type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках. +
  include('../password.php');
  $db = new PDO(
    'mysql:host=localhost;dbname=u67335',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
  $login = $_POST['login'];
  $pass = $_POST['pass'];
  $sth = $db->prepare("SELECT id, login, password FROM log_pass WHERE login = $login and password = $pass");
  $sth->execute();
  $log_pass = $sth->fetchAll();

  $error_l_p = TRUE;
  if ($_POST['login'] == $log_pass[0]['login'] && $_POST['pass'] == $log_pass[0]['password']) {
    $error_l_p = FALSE;
    }
  }
  if ($error_l_p == TRUE)
  {
    print('Данный пользователь не найден в базе данных.<br/>');
  }
  else {
    if (!$session_started) {
      session_start();
    }
    // Если все ок, то авторизуем пользователя.
    $_SESSION['login'] = $_POST['login'];

    // Записываем ID пользователя.
    $_SESSION['uid'] = $log_pass[0]['id']; // было 123
  
    // Делаем перенаправление.
    header('Location: ./');
}

