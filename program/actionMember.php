<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('password.php');
    if (isset($_POST['change'])) {
        setcookie('id_value', $_POST['id'], time() + 24 * 60 * 60);
        setcookie('fio_value', $_POST['fio'], time() + 24 * 60 * 60);
        setcookie('tel_value', $_POST['tel'], time() + 24 * 60 * 60);
        setcookie('email_value', $_POST['email'], time() + 24 * 60 * 60);
        $pos1 = strpos($_POST['birth'],'.');
        $pos2 = strrpos($_POST['birth'],'.');
        setcookie('year_value', intval(substr($_POST['birth'], $pos2 + 1, 4)), time() + 24 * 60 * 60);
        setcookie('month_value', intval(substr($_POST['birth'], $pos1 + 1, $pos2 - $pos1 - 1)), time() + 24 * 60 * 60);
        setcookie('day_value', intval(substr($_POST['birth'], 0, $pos1)), time() + 24 * 60 * 60);
        setcookie('gender_value', $_POST['gender'], time() + 24 * 60 * 60);
        setcookie('post_value', $_POST['post'], time() + 24 * 60 * 60);
        header('Location: indexMember.php');
    } elseif (isset($_POST['delete'])) {
        $stmt = $db->prepare("DELETE FROM members WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $stmt = $db->prepare("DELETE FROM events_members WHERE id_member = ?");
        $stmt->execute([$_POST['id']]);

        $sth = $db->prepare("SELECT id FROM members");
        $sth->execute();
        $members = $sth->fetchAll();
        $i = 1;
        foreach ($members as $member) {
            $stmt = $db->prepare("UPDATE members SET id = ? WHERE id = ?");
            $stmt->execute([$i, $member['id']]);
            $stmt = $db->prepare("UPDATE events_members SET id_member = ? WHERE id_member = ?");
            $stmt->execute([$i, $member['id']]);
            $i++;
        }
        include('events_membersRenameID');
        setcookie('save', '1');
        header('Location: index.php');
    }
}