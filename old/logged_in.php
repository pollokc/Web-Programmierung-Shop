<?php

$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');

$statement = $pdo->prepare("SELECT COUNT(*) FROM benutzer WHERE logged_in = :logged_in");
$statement->execute(array("logged_in" => 1));
$number = $statement->fetchColumn();

echo $number;
?>