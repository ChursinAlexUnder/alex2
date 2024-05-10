<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['tel'] = !empty($_COOKIE['tel_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['year'] = !empty($_COOKIE['year_error']);
    $errors['month'] = !empty($_COOKIE['month_error']);
    $errors['day'] = !empty($_COOKIE['day_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['post'] = !empty($_COOKIE['post_error']);

    if ($errors['fio']) {
        setcookie('fio_error', '', 100000);
        setcookie('fio_value', '', 100000);
        $messages['fio'] = '<div class="error">Заполните ФИО правильно.</div>';
    }
    if ($errors['tel']) {
        setcookie('tel_error', '', 100000);
        setcookie('tel_value', '', 100000);
        $messages['tel'] = '<div class="error">Заполните номер телефона правильно.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages['email'] = '<div class="error">Заполните адрес электронной почты правильно.</div>';
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
    if ($errors['post']) {
        setcookie('post_error', '', 100000);
        setcookie('post_value', '', 100000);
        $messages['post'] = '<div class="error">Напишите что-нибудь о себе.</div>';
    }

    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $values['month'] = empty($_COOKIE['month_value']) ? '' : $_COOKIE['month_value'];
    $values['day'] = empty($_COOKIE['day_value']) ? '' : $_COOKIE['day_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['post'] = empty($_COOKIE['post_value']) ? '' : $_COOKIE['post_value'];

    include ('member.php');
} else {
    $errors = FALSE;
    if (empty($_POST['fio']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+\s+[a-zA-Zа-яА-ЯёЁ]+$/u', $_POST['fio']) || strlen($_POST['fio']) > 150) {
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('fio_value', $_POST['fio'], time() + 24 * 60 * 60);

    if (empty($_POST['tel']) || !preg_match('/^\+?([0-9]{11})$/', $_POST['tel'])) {
        setcookie('tel_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('tel_value', $_POST['tel'], time() + 24 * 60 * 60);

    if (empty($_POST['email']) || !preg_match('/^[A-Za-z0-9_]+@[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('email_value', $_POST['email'], time() + 24 * 60 * 60);

    if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
        setcookie('year_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('year_value', $_POST['year'], time() + 24 * 60 * 60);

    if (empty($_POST['month']) || !is_numeric($_POST['month']) || !preg_match('/^\d+$/', $_POST['month'])) {
        setcookie('month_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('month_value', $_POST['month'], time() + 24 * 60 * 60);

    $months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    $months[1] += ($_POST['year'] % 4 == 0);

    if (empty($_POST['day']) || $_POST['day'] > $months[$_POST['month'] - 1] || !is_numeric($_POST['day']) || !preg_match('/^\d+$/', $_POST['day'])) {
        setcookie('day_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('day_value', $_POST['day'], time() + 24 * 60 * 60);

    if (empty($_POST['gender']) || ($_POST['gender'] != 'man' && $_POST['gender'] != 'woman')) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('gender_value', $_POST['gender'], time() + 24 * 60 * 60);

    if (empty($_POST['post']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,:;-]+$/u', $_POST['post'])) {
        setcookie('post_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('post_value', $_POST['post'], time() + 24 * 60 * 60);

    if ($errors) {
        header('Location: indexMember.php');
        exit();
    } else {
        setcookie('fio_error', '', 100000);
        setcookie('tel_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('year_error', '', 100000);
        setcookie('month_error', '', 100000);
        setcookie('day_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('post_error', '', 100000);
    }

    include ('password.php');
    try {
        if (!empty($_COOKIE['id_value'])) {
            $id = $_COOKIE['id_value'];
            $stmt = $db->prepare("UPDATE members SET fio = ?, tel = ?, email = ?, birth = ?, gender = ?, post = ? WHERE id = ?");
            $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['gender'], $_POST['post'], $id]);
            setcookie('id_value', '', 100000);
        } else {
            $sth = $db->prepare("SELECT id FROM members");
            $sth->execute();
            $members = $sth->fetchAll();
            $stmt = $db->prepare("INSERT INTO members SET id = ?, fio = ?, tel = ?, email = ?, birth = ?, gender = ?, post = ?");
            $stmt->execute([count($members) + 1, $_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['day'] . ':' . $_POST['month'] . ':' . $_POST['year'], $_POST['gender'], $_POST['post']]);
        }
    } catch (PDOException $e) {
        print ('Error : ' . $e->getMessage());
        exit();
    }

    setcookie('save', '1');
    setcookie('fio_value', '', 100000);
    setcookie('tel_value', '', 100000);
    setcookie('email_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('month_value', '', 100000);
    setcookie('day_value', '', 100000);
    setcookie('gender_value', '', 100000);
    setcookie('post_value', '', 100000);
    header('Location: index.php');
}