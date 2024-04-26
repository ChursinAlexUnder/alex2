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
if (!empty($_COOKIE[session_name()]) && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
    ?>
        <div>Пользователь уже авторизован</div>
        <input type="submit" name="logout" value="Выход"/>
    <?php
    if (isset($_POST['logout'])) {
      session_destroy();
      // Делаем перенаправление на форму. ???
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
  include('../password.php');
  $db = new PDO(
    'mysql:host=localhost;dbname=u67335',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
  $login = $_POST['login'];
  $pass = md5($_POST['pass']);
  $sth = $db->prepare("SELECT id, login, password FROM log_pass");
  $sth->execute();
  $log_pass = $sth->fetchAll();
  
  print($log_pass[0][1]);

  $flagSign = false;
  foreach ($log_pass as $l_p) {
    if ($login == $l_p['login'] && $pass == $l_p['password']) {
      $flagSign = true;
      break;
    }
  }

  if ($flagSign == true) {
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
  else {
    print('Данный пользователь не найден в базе данных.<br/>');
  }
}
