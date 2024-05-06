<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    // Выводим сообщение пользователю.
    $messages['success'] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['pass'])) {
      $messages['session'] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }
  

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['tel'] = !empty($_COOKIE['tel_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['month'] = !empty($_COOKIE['month_error']);
  $errors['day'] = !empty($_COOKIE['day_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['languages'] = !empty($_COOKIE['languages_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['checkBut'] = !empty($_COOKIE['checkBut_error']);

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    setcookie('fio_value', '', 100000);
    // Выводим сообщение.
    $messages['fio'] = '<div class="error">Заполните ФИО правильно.<br>Доступные символы: руский алфавит, ангийский алфавит, пробельные символы.</div>';
  }
  if ($errors['tel']) {
    setcookie('tel_error', '', 100000);
    setcookie('tel_value', '', 100000);
    $messages['tel'] = '<div class="error">Заполните номер телефона правильно.<br>Доступные символы: +0123456789.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    setcookie('email_value', '', 100000);
    $messages['email'] = '<div class="error">Заполните адрес электронной почты правильно.<br>Доступные символы: .@ и английский алфавит.</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    setcookie('year_value', '', 100000);
    $messages['year'] = '<div class="error">Заполните год рождения правильно.</div>';
  }
  if ($errors['month']) {
    setcookie('month_error', '', 100000);
    setcookie('month_value', '', 100000);
    $messages['month'] = '<div class="error">Заполните месяц рождения правильно.</div>';
  }
  if ($errors['day']) {
    setcookie('day_error', '', 100000);
    setcookie('day_value', '', 100000);
    $messages['day'] = '<div class="error">Заполните день рождения правильно.</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    setcookie('gender_value', '', 100000);
    $messages['gender'] = '<div class="error">Укажите ваш пол.</div>';
  }
  if ($errors['languages']) {
    setcookie('languages_error', '', 100000);
    setcookie('languages_value', '', 100000);
    $messages['languages'] = '<div class="error">Выберите любимые языки программирования правильно.</div>';
  }
  if ($errors['biography']) {
    setcookie('biography_error', '', 100000);
    setcookie('biography_value', '', 100000);
    $messages['biography'] = '<div class="error">Напишите что-нибудь о себе.<br>Доступные символы: русский и английские алфавиты, цифры, пробельные символы, символы: !?.,:;-.</div>';
  }
  if ($errors['checkBut']) {
    setcookie('checkBut_error', '', 100000);
    setcookie('checkBut_value', '', 100000);
    $messages['checkBut'] = '<div class="error">Поставьте галочку.</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  // При этом санитизуем все данные для безопасного отображения в браузере.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : strip_tags($_COOKIE['tel_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['year'] = empty($_COOKIE['year_value']) ? '' : strip_tags($_COOKIE['year_value']);
  $values['month'] = empty($_COOKIE['month_value']) ? '' : strip_tags($_COOKIE['month_value']);
  $values['day'] = empty($_COOKIE['day_value']) ? '' : strip_tags($_COOKIE['day_value']);
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_COOKIE['gender_value']);
  $values['languages'] = empty($_COOKIE['languages_value']) ? '' : unserialize(strip_tags($_COOKIE['languages_value']));
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : strip_tags($_COOKIE['biography_value']);
  $values['checkBut'] = empty($_COOKIE['checkBut_value']) ? '' : strip_tags($_COOKIE['checkBut_value']);

  function condition_lang($values, $tmp)
  {
    if (!empty($values) && !empty($values['languages'])) {
      foreach($values['languages'] as $value) {
        if ($value == $tmp) {
          print("selected");
        }
      }
    }
  }

  include('../password.php');

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
    $uid = $_SESSION['uid'];
    $sth = $db->prepare("SELECT * FROM users5 where id = $uid");
    $sth->execute();
    $user = $sth->fetchAll();
    $values['fio'] = strip_tags($user[0]['fio']);
    $values['tel'] = strip_tags($user[0]['tel']);
    $values['email'] = strip_tags($user[0]['email']);
    $pos1 = strpos(strip_tags($user[0]['birth']),'.');
    $values['day']=strip_tags(intval(substr($user[0]['birth'], 0, $pos1)));

    $pos2 = strrpos(strip_tags($user[0]['birth']),'.');
    $values['month']=strip_tags(intval(substr($user[0]['birth'], $pos1 + 1, $pos2 - $pos1 - 1)));
    $values['year']=strip_tags(intval(substr($user[0]['birth'], $pos2 + 1, 4)));
    $values['gender'] = strip_tags($user[0]['gender']);

    $sth = $db->prepare("SELECT id_lang FROM users_languages5 where id_user = $uid");
    $sth->execute();
    $languages = $sth->fetchAll();
    $values['languages'] = array();
    foreach($languages as $l) {
      array_push($values['languages'], strip_tags($l['id_lang']));
    }
    $values['biography'] = strip_tags($user[0]['biography']);
    $values['checkBut'] = strip_tags($user[0]['checkBut']);
    printf('Вход с логином %s, ID пользователя %d', $_SESSION['login'], $_SESSION['uid']);
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['fio']) || !preg_match('/[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+/u', $_POST['fio']) || strlen($_POST['fio']) > 150) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('fio_value', $_POST['fio'], time() + 12 * 30 * 24 * 60 * 60);
  if (empty($_POST['tel']) || !preg_match('/^\+?([0-9]{11})/', $_POST['tel'])) {
    setcookie('tel_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('tel_value', $_POST['tel'], time() + 12 * 30 * 24 * 60 * 60);

  if (empty($_POST['email']) || !preg_match('/^[A-Za-z0-9_]+@[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('email_value', $_POST['email'], time() + 12 * + 30 * 24 * 60 * 60);

  if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('year_value', $_POST['year'], time() + 12 * 30 * 24 * 60 * 60);

  if (empty($_POST['month']) || !is_numeric($_POST['month']) || !preg_match('/^\d+$/', $_POST['month'])) {
    setcookie('month_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('month_value', $_POST['month'], time() + 12 * 30 * 24 * 60 * 60);

  $months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  $months[1] += ($_POST['year'] % 4 == 0);

  if (empty($_POST['day']) || $_POST['day'] > $months[$_POST['month'] - 1] || !is_numeric($_POST['day']) || !preg_match('/^\d+$/', $_POST['day'])) {
    setcookie('day_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('day_value', $_POST['day'], time() + 12 * 30 * 24 * 60 * 60);

  if (empty($_POST['gender']) || ($_POST['gender'] != 'man' && $_POST['gender'] != 'woman')) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('gender_value', $_POST['gender'], time() + 12 * 30 * 24 * 60 * 60);


  $error_lang = FALSE;
  if (empty($_POST['languages'])) {
    setcookie('languages_error', '1', time() + 24 * 60 * 60);
    $error_lang = TRUE;
    $errors = TRUE;
  }
  else {
    include('../password.php');
    $sth = $db->prepare("SELECT id FROM languages");
    $sth->execute();

    $langs = $sth->fetchAll();

    $error_lang;
    foreach ($_POST['languages'] as $id_lang) {
      $error_lang = TRUE;
      foreach ($langs as $lang) {
        if ($id_lang == $lang[0]) {
          $error_lang = FALSE;
          break;
        }
      }
      if ($error_lang == TRUE) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
        break;
      }
    }
  }
  setcookie('languages_value', serialize($_POST['languages']), time() + 12 * 30 * 24 * 60 * 60);

  if (empty($_POST['biography']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?:;-]+$/u', $_POST['biography'])) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('biography_value', $_POST['biography'], time() + 12 * 30 * 24 * 60 * 60);


  if (empty($_POST['checkBut']) || $_POST['checkBut'] != 'on') {
    setcookie('checkBut_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('checkBut_value', $_POST['checkBut'], time() + 12 * 30 * 24 * 60 * 60);


  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('tel_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('month_error', '', 100000);
    setcookie('day_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('languages_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('checkBut_error', '', 100000);
  }

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
    $id = intval($_SESSION['uid']);
    try {
      $stmt = $db->prepare("UPDATE users5 SET fio = ?, tel = ?, email = ?, birth = ?, gender = ?, biography = ?, checkBut = ? where id = $id");
      $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['gender'], $_POST['biography'], true]);

      $sth = $db->prepare("SELECT id FROM users_languages5 where id_user = ?");
      $sth->execute([$id]);
      $all_id = $sth->fetchAll();
      $first_id = intval($all_id[0]['id']);

      print(strval($id) . '  '. strval($first_id));
      
      $stmt = $db->prepare("DELETE FROM users_languages5 where id_user = ?");
      $stmt->execute([$id]);

      $stmt = $db->prepare("INSERT INTO users_languages5 (id, id_user, id_lang) VALUES (:id, :id_user, :id_lang)");
      foreach ($_POST['languages'] as $id_lang) {
        // Вставляем $id_lang в БД
        $stmt->bindParam(':id', $first_id);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_lang', $id_lang);
        $id_user = $id;
        $stmt->execute();
        $first_id++;
    }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }

  }
  else {
    // Генерируем уникальный логин и пароль.
    $login = uniqid('login_');
    $password = uniqid();
    // Сохраняем в Cookies.
    setcookie('login', $login, time() + 12 * 30 * 24 * 60 * 60);
    setcookie('pass', $password, time() + 12 * 30 * 24 * 60 * 60);
    try {
      $stmt = $db->prepare("INSERT INTO users5 SET fio = ?, tel = ?, email = ?, birth = ?, gender = ?, biography = ?, checkBut = ?");
      $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['gender'], $_POST['biography'], true]);
  
      $id = $db->lastInsertId();
  
      $stmt = $db->prepare("INSERT INTO users_languages5 (id_user, id_lang) VALUES (:id_user, :id_lang)");
      foreach ($_POST['languages'] as $id_lang) {
        // Вставляем $id_lang в БД
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_lang', $id_lang);
        $id_user = $id;
        $stmt->execute();
      }

      $stmt = $db->prepare("INSERT INTO log_pass5 SET login = ?, password = ?");
      $stmt->execute([$login, md5($password)]);
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: ./');
}
