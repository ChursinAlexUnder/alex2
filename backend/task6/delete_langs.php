<?php
    $stmt = $db->prepare("DELETE FROM users_languages where id_user = ?");
    $stmt->execute([$id]);