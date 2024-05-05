<?php
    $stmt = $db->prepare("DELETE FROM users_languages where id_user = ?");
    $stmt->execute([$id]);
    include('select_u_l.php');
    $index = 0;
    for ($i = 1; $i <= $countId; $i++) {
        $stmt = $db->prepare("UPDATE users_languages SET id = $i where id = strval($users_langs[$index]['id'])");
        $stmt->execute();
        $index++;
    }
