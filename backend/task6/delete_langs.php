<?php
    $stmt = $db->prepare("DELETE FROM users_languages where id_user = ?");
    $stmt->execute([$id]);
    include('select_u_l.php');
    $countId = count($users_langs);
    $index = 0;
    for ($i = 1; $i <= $countId; $i++) {
        $tempUL = intval($users_langs[$index]['id']);
        $stmt = $db->prepare("UPDATE users_languages SET id = ? where id = $tempUL");
        $stmt->execute([$i]);
        $index++;
    }
