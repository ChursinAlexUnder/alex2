<link rel="stylesheet" href="style.css">
<section>
  <h1>Форма</h1>
  <form action="index.php" method="POST">
    <label>
      ФИО:<br>
      <input name="fio" type="text" placeholder="Введите ваши ФИО" />
    </label><br>
    <label>
      Телефон:<br>
      <input name="tel" type="tel" placeholder="Введите ваш номер телефона" />
    </label><br>
    <label>
      Email:<br>
      <input name="email" type="email" placeholder="Введите вашу почту" />
    </label><br>
    <label>
      Год рождения:<br>
      <select name="year">
        <?php
        for ($i = 1922; $i <= 2024; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
        }
        ?>
      </select><br>
      Месяц рождения:<br>
      <select name="month">
        <?php
        for ($i = 1; $i <= 12; $i++) {
          printf('<option value="%d">%d месяц</option>', $i, $i);
        }
        ?>
      </select><br>
      День рождения:<br>
      <select name="day">
        <?php
        for ($i = 1; $i <= 31; $i++) {
          printf('<option value="%d">%d день</option>', $i, $i);
        }
        ?>
      </select><br>
    </label>
    <div class="rowradio">
      Пол:
      <label class="labelradio">
        <input class="radiobutton" type="radio" name="gender" value="man" /> Мужской
      </label>
      <label class="labelradio">
        <input class="radiobutton" type="radio" name="gender" value="woman" /> Женский
      </label>
    </div><br>
    <label>
      Любимый язык программирования:
      <br>
      <select name="languages[]" multiple="multiple">
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
      <textarea name="biography" placeholder="О себе"></textarea>
    </label>
    <br>
    <label class="labelcheck">
      С контрактом ознакомлен (а)
      <input type="checkbox" name="checkBut" />
    </label><br>
    <input type="submit" value="Сохранить" />
  </form>
</section>