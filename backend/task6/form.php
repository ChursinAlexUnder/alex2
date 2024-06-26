<html>
  <head>
    <link rel="stylesheet" href="style.css">
      <style>
        /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
        .error {
          border: 2px solid red;
        }
      </style>
  </head>
  <body>
    <?php
    if (!empty($messages['success'])) {
      print('<div class="mes" id="messages">');
      print($messages['success']);
      print('</div>');
      print('<br>');
    }
    if (!empty($messages['session'])) {
      print('<div class="mes" id="messages">');
      print($messages['session']);
      print('</div>');
      print('<br>');
    }
    if (!empty($messages['admin'])) {
      print('<div class="mes" id="messages">');
      print($messages['admin']);
      print('</div>');
      print('<br>');
    }
    ?>
    <section>
      <h1>Форма</h1>
      <form action="index.php" method="POST">
        <label>
        ФИО:<br>
        <input name="fio" type="text" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="Введите ваши ФИО" />
        </label><br>
        <?php if ($errors['fio']) {print($messages['fio']); print('<br>');}?>
        <label>
        Телефон:<br>
        <input name="tel" type="tel" <?php if ($errors['tel']) {print 'class="error"';} ?> value="<?php print $values['tel']; ?>" placeholder="Введите ваш номер телефона" />
        </label><br>
        <?php if ($errors['tel']) {print($messages['tel']); print('<br>');}?>
        <label>
        Email:<br>
        <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="Введите вашу почту" />
        </label><br>
        <?php if ($errors['email']) {print($messages['email']); print('<br>');}?>
        <label>
          Год рождения:<br>
          <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
            <?php
            for ($i = 1922; $i <= 2024; $i++) {
              printf('<option %s value="%d">%d год</option>', $values['year'] == $i ? 'selected' : '', $i, $i);
            }
            ?>
          </select><br>
          <?php if ($errors['year']) {print($messages['year']); print('<br>');}?>
          Месяц рождения:<br>
          <select name="month" <?php if ($errors['month']) {print 'class="error"';} ?>>
            <?php
            for ($i = 1; $i <= 12; $i++) {
              printf('<option %s value="%d">%d месяц</option>', $values['month'] == $i ? 'selected' : '', $i, $i);
            }
            ?>
          </select><br>
          <?php if ($errors['month']) {print($messages['month']); print('<br>');}?>
          День рождения:<br>
          <select name="day" <?php if ($errors['day']) {print 'class="error"';} ?>>
            <?php
            for ($i = 1; $i <= 31; $i++) {
              printf('<option %s value="%d">%d день</option>', $values['day'] == $i ? 'selected' : '', $i, $i);
            }
            ?>
          </select><br>
          <?php if ($errors['day']) {print($messages['day']); print('<br>');}?>
        </label>
        <label class="labelradio <?php if ($errors['gender']) {print " error";} ?>">
          Пол:
          <input class="radiobutton" type="radio" name="gender" value="man" <?php if ($values['gender'] == 'man') print('checked'); ?>/> Мужской
          <input class="radiobutton" type="radio" name="gender" value="woman" <?php if ($values['gender'] == 'woman') print('checked'); ?>/> Женский
        </label><br>
        <?php if ($errors['gender']) {print($messages['gender']); print('<br>');}?>
        <label>
          Любимый язык программирования:
          <br>
          <select name="languages[]" multiple="multiple" <?php if ($errors['languages']) {print 'class="error"';} ?>>
            <option <?php condition_lang($values, "1")?> value="1">Pascal</option>
            <option <?php condition_lang($values, "2")?> value="2">C</option>
            <option <?php condition_lang($values, "3")?> value="3">C++</option>
            <option <?php condition_lang($values, "4")?> value="4">JavaScript</option>
            <option <?php condition_lang($values, "5")?> value="5">PHP</option>
            <option <?php condition_lang($values, "6")?> value="6">Python</option>
            <option <?php condition_lang($values, "7")?> value="7">Java</option>
            <option <?php condition_lang($values, "8")?> value="8">Haskel</option>
            <option <?php condition_lang($values, "9")?> value="9">Clojure</option>
            <option <?php condition_lang($values, "10")?> value="10">Prolog</option>
            <option <?php condition_lang($values, "11")?> value="11">Scala</option>
          </select>
        </label><br>
        <?php if ($errors['languages']) {print($messages['languages']); print('<br>');}?>
        <label>
          Биография:<br>
          <textarea name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> placeholder="О себе"><?php print $values['biography']; ?></textarea>
        </label><br>
        <?php if ($errors['biography']) {print($messages['biography']); print('<br>');}?>
        <label class="labelcheck <?php if ($errors['checkBut']) {print " error";} ?>">
          С контрактом ознакомлен (а)
          <input type="checkbox" <?php if (!empty($values['checkBut'])) {print('checked');} ?> name="checkBut" />
        </label><br>
        <?php if ($errors['checkBut']) {print($messages['checkBut']); print('<br>');}?>
        <input class="finalBut Button" type="submit" value="Ok" />
      </form>
    </section>
  </body>
</html>
