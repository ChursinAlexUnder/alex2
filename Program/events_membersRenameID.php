<?php
$sth = $db->prepare("SELECT id FROM events_members");
$sth->execute();
$events_members = $sth->fetchAll();
$i = 1;
foreach ($events_members as $event_member) {
    $stmt = $db->prepare("UPDATE events_members SET id = ? WHERE id = ?");
    $stmt->execute([$i, $event['id']]);
    $i++;
}