<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');

//Aktualisierung Last_Login und Logged_in setzen
$statement = $pdo->prepare("UPDATE benutzer SET last_login = :last_login, logged_in = :logged_in WHERE id = :id");
$statement->execute(array('last_login' => date('Y-m-d H:i:s', time()),'logged_in' => 0, 'id' => $_SESSION['userid']));

session_unset();
session_destroy();

header("Location: index.php");

?>