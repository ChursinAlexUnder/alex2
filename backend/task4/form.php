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
    if (!empty($messages)) {
      print('<div id="messages">');
      // Выводим все сообщения.
      foreach ($messages as $message) {
        print($message);
      }
      print('</div>');
    }

    // Далее выводим форму отмечая элементы с ошибками классом error
    // и задавая начальные значения элементов ранее сохраненными.
    ?>
    <section>
      <h1>Форма</h1>
      <form action="" method="POST">
        <label>
        ФИО:<br>
        <input name="fio" type="text" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="Введите ваши ФИО" />
        </label><br>
        <label>
        Телефон:<br>
        <input name="tel" type="tel" <?php if ($errors['tel']) {print 'class="error"';} ?> value="<?php print $values['tel']; ?>" placeholder="Введите ваш номер телефона" />
        </label><br>
        <label>
        Email:<br>
        <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="Введите вашу почту" />
        </label><br>
        <label>
          Год рождения:<br>
          <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>">
            <?php
            for ($i = 1922; $i <= 2024; $i++) {
              printf('<option value="%d">%d год</option>', $i, $i);
            }
            ?>
          </select><br>
          Месяц рождения:<br>
          <select name="month" <?php if ($errors['month']) {print 'class="error"';} ?> value="<?php print $values['month']; ?>">
            <?php
            for ($i = 1; $i <= 12; $i++) {
              printf('<option value="%d">%d месяц</option>', $i, $i);
            }
            ?>
          </select><br>
          День рождения:<br>
          <select name="day" <?php if ($errors['day']) {print 'class="error"';} ?> value="<?php print $values['day']; ?>">
            <?php
            for ($i = 1; $i <= 31; $i++) {
              printf('<option value="%d">%d день</option>', $i, $i);
            }
            ?>
          </select><br>
        </label>
        <div class="rowradio <?php if ($errors['gender']) {print " error";} ?>">
          Пол:
          <label class="labelradio">
            <input class="radiobutton" type="radio" name="gender" value="<?php print $values['gender']; ?>" /> Мужской
          </label>
          <label class="labelradio">
            <input class="radiobutton" type="radio" name="gender" value="<?php print $values['gender']; ?>" /> Женский
          </label>
        </div><br>
        <label>
          Любимый язык программирования:
          <br>
          <select name="languages[]" multiple="multiple" <?php if ($errors['languages']) {print 'class="error"';} ?> value="<?php print $values['languages']; ?>">
            <option value="1">Pascal</option>
            <option value="2">C</option>
            <option value="3">C++</option>
            <option value="4">JavaScript</option>
            <option value="5">PHP</option>
            <option value="6">Python</option>
            <option value="7">Java</option>
            <option value="8">Haskel</option>
            <option value="9">Clojure</option>
            <option value="10">Prolog</option>
            <option value="11">Scala</option>
          </select>
        </label><br>
        <label>
          Биография:<br>
          <textarea name="biography" <?php if ($errors['biography']) {print 'class="error"';} ?> value="<?php print $values['biography']; ?>" placeholder="О себе"></textarea>
        </label>
        <br>
        <label class="labelcheck <?php if ($errors['checkBut']) {print " error";} ?>">
          С контрактом ознакомлен (а)
          <input type="checkbox" value="<?php print $values['checkBut']; ?>" name="checkBut" />
        </label><br>
        <input class="finalBut" type="submit" value="Ok" />
      </form>
    </section>
  </body>
</html>
