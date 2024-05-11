<html>
<head>
    <link rel="stylesheet" href="style.css">
    <style>
        .error {
            border: 2px solid red;
        }
    </style>
</head>
<body>
    <form action="indexEvent.php" method="POST">
        <h1>Новое мероприятие</h1>
        Название:<br>
        <input class="information" name="name" type="text" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" placeholder="Введите название мероприятия"><br>
        <?php if ($errors['name']) {print($messages['name']); print('<br>');}?>
        Город:<br>
        <input class="information" name="city" type="text" <?php if ($errors['city']) {print 'class="error"';} ?> value="<?php print $values['city']; ?>" placeholder="Введите город"><br>
        <?php if ($errors['city']) {print($messages['city']); print('<br>');}?>
        Место проведения:<br>
        <input class="information" name="place" type="text" <?php if ($errors['place']) {print 'class="error"';} ?> value="<?php print $values['place']; ?>" placeholder="Введите адрес"><br>
        <?php if ($errors['place']) {print($messages['place']); print('<br>');}?>
        Дата проведения:<br>
        <select class="information" name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
            <?php
                for ($i = date('Y'); $i <= 2030; $i++) {
                    printf('<option %s value="%d">%d год</option>', $values['year'] == $i ? 'selected' : '', $i, $i);
                }
            ?>
        </select><br>
        <?php if ($errors['year']) {print($messages['year']); print('<br>');}?>
        <select class="information" name="month" <?php if ($errors['month']) {print 'class="error"';} ?>>
            <?php
                for ($i = date('m'); $i <= 12; $i++) {
                    printf('<option %s value="%d">%d месяц</option>', $values['month'] == $i ? 'selected' : '', $i, $i);
                }
            ?>
        </select><br>
        <?php if ($errors['month']) {print($messages['month']); print('<br>');}?>
        <select class="information" name="day" <?php if ($errors['day']) {print 'class="error"';} ?>>
            <?php
                for ($i = date('d'); $i <= 31; $i++) {
                    printf('<option %s value="%d">%d день</option>', $values['day'] == $i ? 'selected' : '', $i, $i);
                }
            ?>
        </select><br>
        <?php if ($errors['day']) {print($messages['day']); print('<br>');}?>
        Время проведения:<br>
        <div class="time">
            <select class="time-1" name="hour" <?php if ($errors['hour']) {print 'class="error"';} ?>>
                <?php
                    for ($i = date('H')+3; $i <= 23; $i++) {
                        printf('<option %s value=%s>%s</option>', $values['hour'] == $i ? 'selected' : '', strlen(strval($i)) == 1 ? '0'.strval($i) : strval($i), strlen(strval($i)) == 1 ? '0'.strval($i) : strval($i));
                    }
                ?>
            </select>
            <?php if ($errors['hour']) {print($messages['hour']); print('<br>');}?>
            <select class="time-1" name="minute" <?php if ($errors['minute']) {print 'class="error"';} ?>>
                <?php
                    for ($i = date('i'); $i <= 59; $i++) {
                        printf('<option %s value=%s>%s</option>', $values['minute'] == $i ? 'selected' : '', strlen(strval($i)) == 1 ? '0'.strval($i) : strval($i), strlen(strval($i)) == 1 ? '0'.strval($i) : strval($i));
                    }
                ?>
            </select><br>
            <?php if ($errors['minute']) {print($messages['minute']); print('<br>');}?>
        </div>
        Участники мероприятия:<br>
        <select class="information" name="team[]" multiple="multiple" <?php if ($errors['team']) {print 'class="error"';} ?>>
            <?php
                include('password.php');
                $sth = $db->prepare("SELECT * FROM members");
                $sth->execute();
                $members = $sth->fetchAll();
                foreach($members as $member) {
                    printf('<option %s value="%d">%s</option>', condition_memb($values, $member['id']), $member['id'], $member['fio']);
                }
            ?>
        </select>
        <?php
            foreach($values['team'] as $value) {
                print($value . '  ');
            }
        ?>
        <div class="finalBut">
            <input class="finalBut-1" type="submit" value="OK" />
        </div>
    </form>
</body>
</html>