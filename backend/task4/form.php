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
      print('<div id="messages">');
      print($messages['success']);
      print('</div>');
    }

    // Далее выводим форму отмечая элементы с ошибками классом error
    // и задавая начальные значения элементов ранее сохраненными.
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
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "1") {print('selected');}}} ?> value="1">Pascal<?php print($values['languages']); ?></option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "2") {print('selected');}}} ?> value="2">C</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "3") {print('selected');}}} ?> value="3">C++</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "4") {print('selected');}}} ?> value="4">JavaScript</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "5") {print('selected');}}} ?> value="5">PHP</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "6") {print('selected');}}} ?> value="6">Python</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "7") {print('selected');}}} ?> value="7">Java</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "8") {print('selected');}}} ?> value="8">Haskel</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "9") {print('selected');}}} ?> value="9">Clojure</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "10") {print('selected');}}} ?> value="10">Prolog</option>
            <option <?php if (!empty($values['languages'])) {foreach($values['languages'] as $value) {if ($value == "11") {print('selected');}}} ?> value="11">Scala</option>
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
        <input class="finalBut" type="submit" value="Ok" />
      </form>
    </section>
  </body>
</html>
