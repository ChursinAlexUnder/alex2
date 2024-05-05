<?php
include('../password.php');
$stmt = $db->prepare("UPDATE l_g_admin SET password = ?,  where id = 1");
$stmt->execute([md5('123')]);