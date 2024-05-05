<?php
    $stmt = $db->prepare("INSERT INTO users_languages (id, id_user, id_lang) VALUES (:id, :id_user, :id_lang)");
    foreach ($_POST['languages'] as $id_lang) {
      // Вставляем $id_lang в БД
      $stmt->bindParam(':id', $tmp_id);
      $stmt->bindParam(':id_user', $id_user);
      $stmt->bindParam(':id_lang', $id_lang);
      $id_user = $id;
      $stmt->execute();
      $tmp_id++;
    }