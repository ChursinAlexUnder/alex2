<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print("Спасибо, результаты сохранены.");
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.

$errors = FALSE;

if (empty($_POST['fio'])) {
  print('Заполните ФИО.<br/>');
  $errors = TRUE;
} else if (!preg_match('/[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+/u', $_POST['fio'])) {
  print('Заполните ФИО правильно.<br/>');
  $errors = TRUE;
} else if (strlen($_POST['fio']) > 150) {
  print('У вас слишком длинное ФИО.<br/>');
  $errors = TRUE;
}

if (empty($_POST['tel'])) {
  print('Заполните телефон.<br/>');
  $errors = TRUE;
} else if (!preg_match('/^\+?([0-9]{11})/', $_POST['tel'])) {
  print('Заполните телефон правильно.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email'])) {
  print('Заполните почту.<br/>');
  $errors = TRUE;
} else if (!preg_match('/^[A-Za-z0-9_]+@[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $_POST['email'])) {
  print('Заполните почту правильно.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}
if (empty($_POST['month'])) {
  print('Заполните месяц.<br/>');
  $errors = TRUE;
}
$months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
$months[1] += ($_POST['year'] % 4 == 0);
if (empty($_POST['day'])) {
  print('Заполните день.<br/>');
  $errors = TRUE;
} else if ($_POST['day'] > $months[$_POST['month'] - 1]) {
  print('Заполните день корректно.<br/>');
  $errors = TRUE;
}

if (empty($_POST['gender'])) {
  print('Выберите пол.<br/>');
  $errors = TRUE;
}

$user = 'u67335'; // Заменить на ваш логин uXXXXX
$pass = '5596746'; // Заменить на пароль, такой же, как от SSH
$db = new PDO(
  'mysql:host=localhost;dbname=u67335',
  $user,
  $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
); // Заменить test на имя БД, совпадает с логином uXXXXX

if (empty($_POST['languages'])) {
  print('Выберите любимый язык программирования.<br/>');
  $errors = TRUE;
} else { // Из сайта: https://www.php.net/manual/en/pdostatement.fetchall.php
  $sth = $db->prepare("SELECT id FROM languages");
  $sth->execute();

  $langs = $sth->fetchAll();

  foreach ($_POST['languages'] as $id_lang) {
    $error_lang = TRUE;
    foreach ($langs as $lang) {
      if ($id_lang == $lang[0]) {
        $error_lang = FALSE;
        break;
      }
    }
    if ($error_lang == TRUE) {
      print('Ошибка! Выбранного языка программирования нет в базе!<br/>');
      $errors = TRUE;
      break;
    }
  }
}

if (empty($_POST['biography'])) {
  print('Введите биографию.<br/>');
  $errors = TRUE;
}

if (empty($_POST['checkBut']) || $_POST['checkBut'] != 'on') {
  print('Ознакомьтесь с контрактом и поставьте галочку.<br/>');
  $errors = TRUE;
}

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

// Подготовленный запрос. Не именованные метки.
// try {
//   $stmt = $db->prepare("INSERT INTO application SET name = ?");
//   $stmt->execute([$_POST['fio']]);
// }
// catch(PDOException $e){
//   print('Error : ' . $e->getMessage());
//   exit();
// }

//  stmt - это "дескриптор состояния".

//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);

//Еще вариант
$stmt = $db->prepare("INSERT INTO users (fio, tel, email, birth, gender, biography, checkBut) VALUES (:fio, :tel, :email, :birth, :gender, :biography, :checkBut)");
$stmt->bindParam(':fio', $fio);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':birth', $birth);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':biography', $biography);
$stmt->bindParam(':checkBut', $checkBut);
$fio = $_POST['fio'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$birth = $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'];
$gender = $_POST['gender'];
$biography = $_POST['biography'];
$checkBut = true;
$stmt->execute();

$id = $db->lastInsertId();

$stmt = $db->prepare("INSERT INTO users_languages (id_user, id_lang) VALUES (:id_user, :id_lang)");
foreach ($_POST['languages'] as $id_lang) {
  // Вставляем $id_lang в БД
  $stmt->bindParam(':id_user', $id_user);
  $stmt->bindParam(':id_lang', $id_lang);
  $id_user = $id;
  $stmt->execute();
}


// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');