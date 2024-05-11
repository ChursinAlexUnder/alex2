<html>
    <head>
        <link rel="stylesheet" href="table.css">
    </head>
    <body>
    <?php
        if (!empty($_COOKIE['save'])) {
            setcookie('save', '', 100000);
            print('<div class="message">База данных успешно изменена.</div><br>');
        }
    ?>
        <h1>Партийная работа</h1>
        <h2>Список членов партии</h2>
        <table class="members">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Дата рождения</th>
                <th>Пол</th>
                <th>Должность</th>
                <th class="nullCell"></th>
            </tr>
            <?php
                include('password.php');
                $sth = $db->prepare("SELECT * FROM members");
                $sth->execute();
                $members = $sth->fetchAll();
                foreach($members as $member) {
                    printf('<tr>
                    <td>%d</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td class="nullCell">
                        <form class="nullForm" action="actionMember.php" method="POST">
                            <input type="hidden" name="id" value=%d>
                            <input type="hidden" name="fio" value="%s">
                            <input type="hidden" name="tel" value="%s">
                            <input type="hidden" name="email" value="%s">
                            <input type="hidden" name="birth" value="%s">
                            <input type="hidden" name="gender" value="%s">
                            <input type="hidden" name="post" value="%s">
                            <input type="submit" name="change" class="ButtonCh" value="изменить"/>
                            <input type="submit" name="delete" class="ButtonDel" value="удалить"/>
                        </form>
                    </td>
                    </tr>',
                    $member['id'], $member['fio'], $member['tel'], $member['email'],
                    $member['birth'], $member['gender'], $member['post'],
                    $member['id'], $member['fio'], $member['tel'], $member['email'],
                    $member['birth'], $member['gender'], $member['post']);
                }
            ?>
        </table>
        <form action="indexMember.php" method="GET">
            <div class="finalBut">
                <input class="finalBut-1" type="submit" value="Добавить члена партии"/>
            </div>
        </form>
        <h2>Список мероприятий</h2>
        <table class="events">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Город</th>
                <th>Адрес</th>
                <th>Дата проведения</th>
                <th>Время начала</th>
                <th class="nullCell"></th>
            </tr>
            <?php
                $sth = $db->prepare("SELECT * FROM events");
                $sth->execute();
                $events = $sth->fetchAll();
                $sth = $db->prepare("SELECT id_member FROM events_members");
                $sth->execute();
                $events_members = serialize($sth->fetchAll());
                foreach($events as $event) {
                    printf('<tr>
                    <td>%d</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td class="nullCell">
                        <form class="nullForm" action="actionEvent.php" method="POST">
                            <input type="hidden" name="id" value=%d>
                            <input type="hidden" name="name" value="%s">
                            <input type="hidden" name="city" value="%s">
                            <input type="hidden" name="place" value="%s">
                            <input type="hidden" name="date" value="%s">
                            <input type="hidden" name="time" value="%s">
                            <input type="hidden" name="team" value="%s">
                            <input type="submit" name="change" class="ButtonCh" value="изменить"/>
                            <input type="submit" name="delete" class="ButtonDel" value="удалить"/>
                        </form>
                    </td>
                    </tr>',
                    $event['id'], $event['name'], $event['city'], $event['place'],
                    $event['date'], $event['time'],
                    $event['id'], $event['name'], $event['city'], $event['place'],
                    $event['date'], $event['time'], $events_members);
                }
            ?>
        </table>
        <form action="indexEvent.php" method="GET">
            <div class="finalBut">
                <input class="finalBut-1" type="submit" value="Добавить мероприятие"/>
            </div>
        </form>
        <h2>Список учета выхода на мероприятие</h2>
        <table class="events_members">
            <tr>
                <th>ID</th>
                <th>ID мероприятия</th>
                <th>ID участника</th>
                <th>Мероприятие</th>
                <th>Участник</th>
            </tr>
            <?php
                $sth = $db->prepare("SELECT * FROM events_members");
                $sth->execute();
                $events_members = $sth->fetchAll();
                foreach($events_members as $event_member) {
                    $sth = $db->prepare("SELECT name FROM events WHERE id = ?");
                    $sth->execute([$event_member['id_event']]);
                    $event = $sth->fetchAll();
                    $sth = $db->prepare("SELECT fio FROM members WHERE id = ?");
                    $sth->execute([$event_member['id_member']]);
                    $member = $sth->fetchAll();
                    printf('<tr>
                    <td>%d</td>
                    <td>%d</td>
                    <td>%d</td>
                    <td>%s</td>
                    <td>%s</td>
                    </tr>',
                    $event_member['id'], $event_member['id_event'], $event_member['id_member'],
                    $event[0]['name'], $member[0]['fio']);
                }
            ?>
        </table>
        <h2>Список городов</h2>
        <table class="cities">
            <tr>
                <th>ID</th>
                <th>Город</th>
            </tr>
            <?php
                $sth = $db->prepare("SELECT DISTINCT city FROM cities");
                $sth->execute();
                $cities = $sth->fetchAll();
                $i = 1;
                foreach($cities as $city) {
                    printf('<tr>
                    <td>%d</td>
                    <td>%s</td>
                    </tr>',
                    $i, $city['city']);
                    $i++;
                }
            ?>
        </table>
    </body>
</html>