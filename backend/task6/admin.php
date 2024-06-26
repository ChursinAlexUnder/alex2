<link rel="stylesheet" href="style.css">
<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
include('../password.php');
$sth = $db->prepare("SELECT * FROM l_g_admin");
$sth->execute();
$l_g_admin = $sth->fetchAll();
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $l_g_admin[0]['login'] ||
    md5($_SERVER['PHP_AUTH_PW']) != $l_g_admin[0]['password']) {
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
$sth = $db->prepare("SELECT * FROM l_g_admin");
$sth->execute();
$l_g_admin = $sth->fetchAll();
setcookie('admin', $l_g_admin[0]['password'], time() + 24 * 60 * 60);
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

<h2>Статистика популярности языков программирования</h2>
<table class="user_count">
  <tr>
    <th>Язык программирования</th>
    <th>Количество поклонников</th>
  </tr>
  <?php
    $sth = $db->prepare("SELECT l.name AS language_name, COUNT(ul.id_user) AS user_count FROM languages l LEFT JOIN users_languages ul ON l.id = ul.id_lang GROUP BY l.name");
    $sth->execute();
    $user_count = $sth->fetchAll();
    foreach($user_count as $u_c) {
      printf('<tr>
      <td>%s</td>
      <td>%s</td>
      </tr>',
      $u_c['language_name'], $u_c['user_count']);
    }
  ?>
</table>

<form action="index.php" method="POST">
  <input type="submit" class="finalBut Button" name="exit_admin" value="Выход">
</form>
