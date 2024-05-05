<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'change') {
        include('../password.php');
        $sth = $db->prepare("SELECT * FROM log_pass where id = ?");
        $sth->execute([$_POST['id']]);
        $log_pass = $sth->fetchAll();
        session_start();
        $_SESSION['login'] = $log_pass[0]['login'];
        $_SESSION['uid'] = $_POST['id'];
        print('Вход от имени администратора.');
        include('index.php');
        header('Location: admin.php');
    }
    elseif ($_POST['action'] == 'delete') {

    }
}