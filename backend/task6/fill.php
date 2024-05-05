<?php
include('../password.php');
$uid = $_SESSION['uid'];
$sth = $db->prepare("SELECT * FROM users where id = $uid");
$sth->execute();
$user = $sth->fetchAll();
$values['fio'] = strip_tags($user[0]['fio']);
$values['tel'] = strip_tags($user[0]['tel']);
$values['email'] = strip_tags($user[0]['email']);
$pos1 = strpos(strip_tags($user[0]['birth']),'.');
$values['day']=strip_tags(intval(substr($user[0]['birth'], 0, $pos1)));

$pos2 = strrpos(strip_tags($user[0]['birth']),'.');
$values['month']=strip_tags(intval(substr($user[0]['birth'], $pos1 + 1, $pos2 - $pos1 - 1)));
$values['year']=strip_tags(intval(substr($user[0]['birth'], $pos2 + 1, 4)));
$values['gender'] = strip_tags($user[0]['gender']);

$sth = $db->prepare("SELECT id_lang FROM users_languages where id_user = $uid");
$sth->execute();
$languages = $sth->fetchAll();
$values['languages'] = array();
foreach($languages as $l) {
  array_push($values['languages'], $l);
}
$values['biography'] = strip_tags($user[0]['biography']);
$values['checkBut'] = strip_tags($user[0]['checkBut']);
