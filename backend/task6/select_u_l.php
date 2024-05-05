<?php
    $sth = $db->prepare("SELECT * FROM users_languages");
    $sth->execute();
    $users_langs = $sth->fetchAll();