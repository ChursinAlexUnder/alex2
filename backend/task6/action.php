<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../password.php');
    if ($_POST['action'] == 'change') {
        $sth = $db->prepare("SELECT * FROM log_pass where id = ?");
        $sth->execute([$_POST['id']]);
        $log_pass = $sth->fetchAll();
        session_start();
        $_SESSION['login'] = $log_pass[0]['login'];
        $_SESSION['uid'] = $_POST['id'];
        header('Location: index.php');
    }
    elseif ($_POST['action'] == 'delete') {
        try {
            $id = $_POST['id'];
            include('delete_langs.php');
            $stmt = $db->prepare("DELETE FROM users where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM log_pass where id = ?");
            $stmt->execute([$id]);
            include('select_users.php');
            $countId = count($users);
            $indexU = 0;
            for ($i = 1; $i <= $countId; $i++) {
                $tempU = intval($users[$indexU]['id']);
                $stmt = $db->prepare("UPDATE users SET id = ? where id = $tempU");
                $stmt->execute([$i]);
                $stmt = $db->prepare("UPDATE log_pass SET id = ? where id = $tempU");
                $stmt->execute([$i]);
                $stmt = $db->prepare("UPDATE users_languages SET id_user = ? where id_user = $tempU");
                $stmt->execute([$i]);
                $indexU++;
            }
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: admin.php');
    }
}