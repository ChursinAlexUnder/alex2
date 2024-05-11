<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('password.php');
    if (isset($_POST['change'])) {
        setcookie('id_value', $_POST['id'], time() + 24 * 60 * 60);
        setcookie('name_value', $_POST['name'], time() + 24 * 60 * 60);
        setcookie('city_value', $_POST['city'], time() + 24 * 60 * 60);
        setcookie('place_value', $_POST['place'], time() + 24 * 60 * 60);
        $pos1 = strpos($_POST['date'],'.');
        $pos2 = strrpos($_POST['date'],'.');
        setcookie('year_value', intval(substr($_POST['date'], $pos2 + 1, 4)), time() + 24 * 60 * 60);
        setcookie('month_value', intval(substr($_POST['date'], $pos1 + 1, $pos2 - $pos1 - 1)), time() + 24 * 60 * 60);
        setcookie('day_value', intval(substr($_POST['date'], 0, $pos1)), time() + 24 * 60 * 60);
        setcookie('hour_value', intval(substr($_POST['time'], 0, 2)), time() + 24 * 60 * 60);
        setcookie('minute_value', intval(substr($_POST['time'], 3, 2)), time() + 24 * 60 * 60);
        setcookie('team_value', $_POST['team'], time() + 24 * 60 * 60);
        header('Location: indexEvent.php');
    } elseif (isset($_POST['delete'])) {
        $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $stmt = $db->prepare("DELETE FROM events_members WHERE id_event = ?");
        $stmt->execute([$_POST['id']]);
        $stmt = $db->prepare("DELETE FROM cities WHERE id_event = ?");
        $stmt->execute([$_POST['id']]);

        $sth = $db->prepare("SELECT id FROM events");
        $sth->execute();
        $events = $sth->fetchAll();
        $i = 1;
        foreach ($events as $event) {
            $stmt = $db->prepare("UPDATE events SET id = ? WHERE id = ?");
            $stmt->execute([$i, $event['id']]);
            $stmt = $db->prepare("UPDATE events_members SET id_event = ? WHERE id_event = ?");
            $stmt->execute([$i, $event['id']]);
            $stmt = $db->prepare("UPDATE cities SET id_event = ? WHERE id_event = ?");
            $stmt->execute([$i, $event['id']]);
            $i++;
        }
        include('events_membersRenameID');

        $sth = $db->prepare("SELECT id FROM cities");
        $sth->execute();
        $cities = $sth->fetchAll();
        $i = 1;
        foreach ($cities as $city) {
            $stmt = $db->prepare("UPDATE cities SET id = ? WHERE id = ?");
            $stmt->execute([$i, $city['id']]);
            $i++;
        }
        setcookie('save', '1');
        header('Location: index.php');
    }
}