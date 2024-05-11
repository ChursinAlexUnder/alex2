<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['city'] = !empty($_COOKIE['city_error']);
    $errors['place'] = !empty($_COOKIE['place_error']);
    $errors['year'] = !empty($_COOKIE['year_error']);
    $errors['month'] = !empty($_COOKIE['month_error']);
    $errors['day'] = !empty($_COOKIE['day_error']);
    $errors['hour'] = !empty($_COOKIE['hour_error']);
    $errors['minute'] = !empty($_COOKIE['minute_error']);
    $errors['team'] = !empty($_COOKIE['team_error']);

    if ($errors['name']) {
        setcookie('name_error', '', 100000);
        setcookie('name_value', '', 100000);
        $messages['name'] = '<div class="error">Заполните название правильно.</div>';
    }
    if ($errors['city']) {
        setcookie('city_error', '', 100000);
        setcookie('city_value', '', 100000);
        $messages['city'] = '<div class="error">Заполните город правильно.</div>';
    }
    if ($errors['place']) {
        setcookie('place_error', '', 100000);
        setcookie('place_value', '', 100000);
        $messages['place'] = '<div class="error">Заполните адрес правильно.</div>';
    }
    if ($errors['year']) {
        setcookie('year_error', '', 100000);
        setcookie('year_value', '', 100000);
        $messages['year'] = '<div class="error">Заполните год правильно.</div>';
    }
    if ($errors['month']) {
        setcookie('month_error', '', 100000);
        setcookie('month_value', '', 100000);
        $messages['month'] = '<div class="error">Заполните месяц правильно.</div>';
    }
    if ($errors['day']) {
        setcookie('day_error', '', 100000);
        setcookie('day_value', '', 100000);
        $messages['day'] = '<div class="error">Заполните день правильно.</div>';
    }
    if ($errors['hour']) {
        setcookie('hour_error', '', 100000);
        setcookie('hour_value', '', 100000);
        $messages['hour'] = '<div class="error">Заполните время (часы) правильно.</div>';
    }
    if ($errors['minute']) {
        setcookie('minute_error', '', 100000);
        setcookie('minute_value', '', 100000);
        $messages['minute'] = '<div class="error">Заполните время (минуты) правильно.</div>';
    }
    if ($errors['team']) {
        setcookie('team_error', '', 100000);
        setcookie('team_value', '', 100000);
        $messages['team'] = '<div class="error">Выберите участников мероприятия.</div>';
    }

    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['city'] = empty($_COOKIE['city_value']) ? '' : $_COOKIE['city_value'];
    $values['place'] = empty($_COOKIE['place_value']) ? '' : $_COOKIE['place_value'];
    $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $values['month'] = empty($_COOKIE['month_value']) ? '' : $_COOKIE['month_value'];
    $values['day'] = empty($_COOKIE['day_value']) ? '' : $_COOKIE['day_value'];
    $values['hour'] = empty($_COOKIE['hour_value']) ? '' : $_COOKIE['hour_value'];
    $values['minute'] = empty($_COOKIE['minute_value']) ? '' : $_COOKIE['minute_value'];
    $values['team'] = empty($_COOKIE['team_value']) ? '' : unserialize($_COOKIE['team_value']);

    function condition_memb($values, $tmp)
    {
        if (!empty($values) && !empty($values['members'])) {
            foreach ($values['members'] as $value) {
                if ($value['id'] == $tmp) {
                    print ("selected");
                }
            }
        }
    }

    include ('event.php');
} else {
    $errors = FALSE;
    if (empty($_POST['name']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,\s]+$/u', $_POST['name']) || strlen($_POST['name']) > 100) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('name_value', $_POST['name'], time() + 24 * 60 * 60);

    if (empty($_POST['city']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,-]+$/u', $_POST['city']) || strlen($_POST['city']) > 100) {
        setcookie('city_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('city_value', $_POST['city'], time() + 24 * 60 * 60);

    if (empty($_POST['place']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,-\/]+$/u', $_POST['place']) || strlen($_POST['place']) > 100) {
        setcookie('place_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('place_value', $_POST['place'], time() + 24 * 60 * 60);

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

    if (empty($_POST['hour']) || !preg_match('/^\d+$/', $_POST['hour'])) {
        setcookie('hour_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('hour_value', $_POST['hour'], time() + 24 * 60 * 60);

    if (empty($_POST['minute']) || !preg_match('/^\d+$/', $_POST['hour'])) {
        setcookie('minute_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('minute_value', $_POST['minute'], time() + 24 * 60 * 60);

    include ('password.php');
    $error_team = FALSE;
    if (!empty($_POST['team'])) {
        $sth = $db->prepare("SELECT id FROM members");
        $sth->execute();
        $members = $sth->fetchAll();

        foreach ($_POST['team'] as $id_memb) {
            $error_team = TRUE;
            foreach ($members as $member) {
                if (intval($id_memb) == $member['id']) {
                    $error_team = FALSE;
                    break;
                }
            }
            if ($error_team == TRUE) {
                setcookie('team_error', '1', time() + 24 * 60 * 60);
                $errors = TRUE;
                break;
            }
        }
    }
    setcookie('team_value', serialize($_POST['team']), time() + 24 * 60 * 60);

    if ($errors) {
        header('Location: indexEvent.php');
        exit();
    } else {
        setcookie('name_error', '', 100000);
        setcookie('city_error', '', 100000);
        setcookie('place_error', '', 100000);
        setcookie('year_error', '', 100000);
        setcookie('month_error', '', 100000);
        setcookie('day_error', '', 100000);
        setcookie('hour_error', '', 100000);
        setcookie('minute_error', '', 100000);
        setcookie('team_error', '', 100000);
    }

    try {
        if (!empty($_COOKIE['id_value'])) {
            $id = $_COOKIE['id_value'];
            $stmt = $db->prepare("UPDATE events SET name = ?, city = ?, place = ?, date = ?, time = ? WHERE id = ?");
            $stmt->execute([$_POST['name'], $_POST['city'], $_POST['place'], $_POST['day'] . '.' . $_POST['month'] . '.' . $_POST['year'], $_POST['hour'] . ':' . $_POST['minute'], $id]);

            $stmt = $db->prepare("DELETE FROM events_members WHERE id_event = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("INSERT INTO events_members SET id_event = ?, id_member = ?");
            foreach ($_POST['team'] as $id_member) {
                $stmt->execute([$id, $id_member]);
            }

            $stmt = $db->prepare("UPDATE cities SET city = ? WHERE id_event = ?");
            $stmt->execute([$_POST['city'], $id]);
            setcookie('id_value', '', 100000);
        } else {
            $sth = $db->prepare("SELECT id FROM events");
            $sth->execute();
            $events = $sth->fetchAll();
            $stmt = $db->prepare("INSERT INTO events SET id = ?, name = ?, city = ?, place = ?, date = ?, time = ?");
            $stmt->execute([count($events) + 1, $_POST['name'], $_POST['city'], $_POST['place'], $_POST['day'] . '.' . $_POST['month'] . '.' . $_POST['year'], $_POST['hour'] . ':' . $_POST['minute']]);

            $id = $db->lastInsertId();
            $sth = $db->prepare("SELECT id FROM events_members");
            $sth->execute();
            $events_members = $sth->fetchAll();
            $i = count($events_members) + 1;
            $stmt = $db->prepare("INSERT INTO events_members SET id = ?, id_event = ?, id_member = ?");
            foreach ($_POST['team'] as $id_member) {
                $stmt->execute([$i, $id, intval($id_member)]);
                $i++;
            }

            $sth = $db->prepare("SELECT id FROM cities");
            $sth->execute();
            $cities = $sth->fetchAll();
            $stmt = $db->prepare("INSERT INTO cities SET id = ?, id_event = ?, city = ?");
            $stmt->execute([count($cities) + 1, $id, $_POST['city']]);
        }
    } catch (PDOException $e) {
        print ('Error : ' . $e->getMessage());
        exit();
    }

    setcookie('save', '1');
    setcookie('name_value', '', 100000);
    setcookie('place_value', '', 100000);
    setcookie('city_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('month_value', '', 100000);
    setcookie('day_value', '', 100000);
    setcookie('hour_value', '', 100000);
    setcookie('minute_value', '', 100000);
    setcookie('team_value', '', 100000);
    header('Location: index.php');
}