<?php
    $sth = $db->prepare("SELECT * FROM users");
    $sth->execute();
    $users = $sth->fetchAll();