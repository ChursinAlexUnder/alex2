<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
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
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
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
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['tel']) {
    setcookie('tel_error', '', 100000);
    $messages[] = '<div class="error">Заполните номер телефона.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните адрес электронной почты.</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Заполните год рождения.</div>';
  }
  if ($errors['month']) {
    setcookie('month_error', '', 100000);
    $messages[] = '<div class="error">Заполните месяц рождения.</div>';
  }
  if ($errors['day']) {
    setcookie('day_error', '', 100000);
    $messages[] = '<div class="error">Заполните день рождения.</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Укажите ваш пол.</div>';
  }
  if ($errors['languages']) {
    setcookie('languages_error', '', 100000);
    $messages[] = '<div class="error">Выберите любимые языки программирования.</div>';
  }
  if ($errors['biography']) {
    setcookie('biography_error', '', 100000);
    $messages[] = '<div class="error">Напишите что-нибудь о себе.</div>';
  }
  if ($errors['checkBut']) {
    setcookie('checkBut_error', '', 100000);
    $messages[] = '<div class="error">Поставьте галочку.</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['month'] = empty($_COOKIE['month_value']) ? '' : $_COOKIE['month_value'];
  $values['day'] = empty($_COOKIE['day_value']) ? '' : $_COOKIE['day_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['languages'] = empty($_COOKIE['languages_value']) ? '' : $_COOKIE['languages_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['checkBut'] = empty($_COOKIE['checkBut_value']) ? '' : $_COOKIE['checkBut_value'];

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['fio'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['tel'])) {
    setcookie('tel_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('tel_value', $_POST['tel'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {

    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['month'])) {
    setcookie('month_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('month_value', $_POST['month'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['day'])) {
    setcookie('day_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('day_value', $_POST['day'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['languages'])) {
    setcookie('languages_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('languages_value', $_POST['languages'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['biography'])) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['checkBut'])) {
    setcookie('checkBut_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('checkBut_value', $_POST['checkBut'], time() + 30 * 24 * 60 * 60);
  }

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

  // Сохранение в БД.

  $user = 'u67335'; // Заменить на ваш логин uXXXXX
  $pass = '5596746'; // Заменить на пароль, такой же, как от SSH
  $db = new PDO(
    'mysql:host=localhost;dbname=u67335',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );

  // Подготовленный запрос. Не именованные метки.
  try {
    $stmt = $db->prepare("INSERT INTO users SET fio = ?, tel = ?, email = ?, birth = ?, gender = ?, biography = ?, checkBut = ?");
    $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['gender'], $_POST['biography'], true]);

    $id = $db->lastInsertId();

    foreach ($_POST['languages'] as $id_lang) {
      // Вставляем $id_lang в БД
      $stmt = $db->prepare("INSERT INTO users_languages (id_user, id_lang) VALUES (:id_user, :id_lang)");
      $stmt->bindParam(':id_user', $id_user);
      $stmt->bindParam(':id_lang', $id_lang);
      $id_user = $id;
      $stmt->execute();
    }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
