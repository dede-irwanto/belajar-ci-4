<?php
$dbh = new PDO('mysql:host=localhost; dbname=ci4', 'root', '');
$db = $dbh->prepare('select * from orang');
$db->execute();
$mahasiswa = $db->fetchAll(PDO::FETCH_ASSOC);

$data = json_encode($mahasiswa);

echo $data;
