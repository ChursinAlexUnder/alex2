<section>
  <h2>Форма</h2>
    <form action="" method="POST">
        <label>
            ФИО:<br>
            <input name="fio" placeholder="Введите ваши ФИО" />
        </label><br>
        <label>
            Телефон:<br>
            <input name="field-tel" type="tel" placeholder="Введите ваш номер телефона" />
        </label><br>
        <label>
            Email:<br>
            <input name="field-email" type="email" placeholder="Введите вашу почту" />
        </label><br>
        <select name="year">
          <?php 
          for ($i = 1922; $i <= 2022; $i++) {
            printf('<option value="%d">%d год</option>', $i, $i);
          }
          ?>
        </select><br>
        <div class="rowradio">
            Пол:
            <label class="labelradio">
                <input class="radiobutton" type="radio" checked="checked" name="radio-group-1" value="Мужской" /> Мужской
            </label>
            <label class="labelradio">
                <input class="radiobutton" type="radio" name="radio-group-1" value="Женский" /> Женский
            </label>
        </div><br>
        <label>
            Любимый язык программирования:
            <br>
            <select name="field-language-2[]" multiple="multiple">
                <option value="Pascal">Pascal</option>
                <option value="C" >C</option>
                <option value="C++" selected="selected">C++</option>
                <option value="JavaScript" >JavaScript</option>
                <option value="PHP" >PHP</option>
                <option value="Python" >Python</option>
                <option value="Java" >Java</option>
                <option value="Haskel" >Haskel</option>
                <option value="Clojure" >Clojure</option>
                <option value="Prolog" >Prolog</option>
                <option value="Scala" >Scala</option>
            </select>
        </label><br>
        <label>
            Биография:<br>
            <textarea name="biography" placeholder="О себе"></textarea>
        </label><br>
        <br>
        <label class="labelcheck">
            С контрактом ознакомлен (а)
            <input type="checkbox" checked="checked" name="check"/>
        </label><br>
        <input type="submit" value="Сохранить"/>
      </form>
</section>
