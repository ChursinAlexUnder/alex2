<?php
    $stmt = $db->prepare("DELETE FROM users_languages where id_user = ?");
    $stmt->execute([$id]);
    include('select_u_l.php');
    $countId = count($users_langs);
    for ($i = 1; $i <= $countId; $i++) {
        $stmt = $db->prepare("UPDATE users_languages SET id = ?");
        $stmt->execute([$i]);
    }
