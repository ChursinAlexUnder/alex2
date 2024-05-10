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
        <?php
        if (!empty($messages['success'])) {
            printf('<div>%s</div><br>', $messages['success']);
        }
        ?>
        <form action="indexMember.php" method="POST">
            <h1>Новый член партии</h1>
            ФИО:<br>
            <input class="information" name="fio" type="text" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="Введите ваши ФИО"><br>
            <?php if ($errors['fio']) {print($messages['fio']); print('<br>');}?>
            Телефон:<br>
            <input class="information" name="tel" type="tel" <?php if ($errors['tel']) {print 'class="error"';} ?> value="<?php print $values['tel']; ?>" placeholder="Введите ваш номер телефона" /><br>
            <?php if ($errors['tel']) {print($messages['tel']); print('<br>');}?>
            Email:<br>
            <input class="information" name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="Введите вашу почту" /><br>
            <?php if ($errors['email']) {print($messages['email']); print('<br>');}?>
            Год рождения:<br>
            <select class="information" name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
                <?php
                    for ($i = 1922; $i <= 2024; $i++) {
                        printf('<option %s value="%d">%d год</option>', $values['year'] == $i ? 'selected' : '', $i, $i);
                    }
                ?>
            </select><br>
            <?php if ($errors['year']) {print($messages['year']); print('<br>');}?>
            Месяц рождения:<br>
            <select class="information" name="month" <?php if ($errors['month']) {print 'class="error"';} ?>>
                <?php
                    for ($i = 1; $i <= 12; $i++) {
                        printf('<option %s value="%d">%d месяц</option>', $values['month'] == $i ? 'selected' : '', $i, $i);
                    }
                ?>
            </select><br>
            <?php if ($errors['month']) {print($messages['month']); print('<br>');}?>
            День рождения:<br>
            <select class="information" name="day" <?php if ($errors['day']) {print 'class="error"';} ?>>
                <?php
                    for ($i = 1; $i <= 31; $i++) {
                        printf('<option %s value="%d">%d день</option>', $values['day'] == $i ? 'selected' : '', $i, $i);
                    }
                ?>
            </select><br>
            <?php if ($errors['day']) {print($messages['day']); print('<br>');}?>
            <label class="information gender <?php if ($errors['gender']) {print " error";} ?>">
                Пол:
                <input type="radio" name="gender" value="man" <?php if ($values['gender'] == 'man') print('checked'); ?>/> Мужской
                <input type="radio" name="gender" value="woman" <?php if ($values['gender'] == 'woman') print('checked'); ?>/> Женский
            </label><br>
            <?php if ($errors['gender']) {print($messages['gender']); print('<br>');}?>
            Должность:<br>
            <input class="information" name="post" type="text" <?php if ($errors['post']) {print 'class="error"';} ?> value="<?php print $values['post']; ?>" placeholder="Введите вашу должность"><br>
            <?php if ($errors['post']) {print($messages['post']); print('<br>');}?>
            <div class="finalBut">
                <input class="finalBut-1" type="submit" value="OK" />
            </div>
        </form>
    </body>
</html>