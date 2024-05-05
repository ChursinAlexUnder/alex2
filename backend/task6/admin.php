<link rel="stylesheet" href="style.css">
<?php

// ЗАШИФРОВАТЬ ЗНАЧЕНИЕ КУКИ АДМИНА!!!!!!!!!

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');
if (!empty($_COOKIE['save'])) {
  print('<br>');
  print('Операция выполнена успешно.');
  setcookie('save', '', 100000);
  setcookie('PHPSESSID', '', 100000, '/');
  setcookie('fio_value', '', 100000);
  setcookie('tel_value', '', 100000);
  setcookie('email_value', '', 100000);
  setcookie('year_value', '', 100000);
  setcookie('month_value', '', 100000);
  setcookie('day_value', '', 100000);
  setcookie('gender_value', '', 100000);
  setcookie('languages_value', '', 100000);
  setcookie('biography_value', '', 100000);
  setcookie('checkBut_value', '', 100000);
}
setcookie('admin', true, time() + 24 * 60 * 60);
include('../password.php');
include('select_users.php');
?>

<h2>Таблица пользователей</h2>
<table class="users">
  <tr>
    <th>ID</th>
    <th>ФИО</th>
    <th>Телефон</th>
    <th>Email</th>
    <th>Дата рождения</th>
    <th>Пол</th>
    <th>Биография</th>
    <th class="nullCell"></th>
    <th class="nullCell"></th>
  </tr>
  <?php
    foreach($users as $user) {
      printf('<tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td class="nullCell">
        <form action="action.php" method="POST">
          <input type="hidden" name="action" value="change">
          <input type="hidden" name="id" value="%d">
          <input type="submit" class="tableButtonCh" value="изменить"/>
        </form>
      </td>
      <td class="nullCell">
        <form action="action.php" method="POST">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="%d">
          <input type="submit" class="tableButtonDel" value="удалить"/>
        </form>
      </td>
      </tr>',
      $user['id'], $user['fio'], $user['tel'], $user['email'],
      $user['birth'], $user['gender'], $user['biography'],
      $user['id'], $user['id']);
    }
  ?>
</table>

<?php
$sth = $db->prepare("SELECT u_l.id_user, lang.name 
FROM users_languages u_l join languages lang on u_l.id_lang = lang.id");
$sth->execute();
$users_lang = $sth->fetchAll();
?>

<h2>Таблица языков программирования</h2>
<table class="languages">
  <tr>
    <th>ID пользователя</th>
    <th>Язык программирования</th>
  </tr>
  <?php
    foreach($users_lang as $user_lang) {
      printf('<tr>
      <td>%s</td>
      <td>%s</td>
      </tr>',
      $user_lang['id_user'], $user_lang['name']);
    }
  ?>
</table>
<form action="index.php" method="POST">
  <input type="submit" name="exit_admin" value="Выход">
</form>

<?php
// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
?>