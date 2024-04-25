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
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
?>
    <form action="" method="post">
      <div>Пользователь уже авторизован</div>
      <input type="submit" value="Выход" />
    </form>
<?php
    if (isset($_POST['Выход'])) {
      // TODO: Сделать выход (окончание сессии вызовом session_destroy()
      //при нажатии на кнопку Выход). +
      session_destroy();
      // Делаем перенаправление на форму.
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
  $sth = $db->prepare("SELECT login, password FROM log_pass");
  $sth->execute();
  $log_pass = $sth->fetchAll();

  $error_l_p = TRUE;
  foreach ($log_pass as $l_p) {
    if ($_POST['login'] == $l_p[0] && $_POST['pass'] == $l_p[1]) {
      $error_l_p = FALSE;
      break;
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
    $sth = $db->prepare("SELECT id FROM log_pass");
    $sth->execute();
    $all_id = $sth->fetchAll();
    $id = (count($all_id) == 0) ? 1 : count($all_id)+1;
    $_SESSION['uid'] = $id; // было 123
  
    // Делаем перенаправление.
    header('Location: ./');
  }
}