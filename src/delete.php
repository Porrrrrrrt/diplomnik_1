<?php
require_once __DIR__ . "/helper.php";
$id=$_GET['id'];
$pdo = new PDO('mysql:host=localhost; dbname=tasks', 'root', '');
$sql="DELETE FROM users WHERE `users`.`id` = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id'=>$id]);
redirect('/../users.php');