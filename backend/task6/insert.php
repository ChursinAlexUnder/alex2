<?php
    include('../password.php');
    $stmt = $db->prepare("INSERT INTO l_g_admin SET login = ?, password = ?");
    $stmt->execute(['admin', md5('1234')]);