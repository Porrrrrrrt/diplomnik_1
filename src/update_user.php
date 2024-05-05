<?php
require_once __DIR__ . "/helper.php";
$username = $_POST['username'] ?? null;
$job_title = $_POST['job_title'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;
$id = $_POST['id'] ?? null;
$pdo = new PDO('mysql:host=localhost;dbname=tasks', 'root', '');
$sql = "UPDATE `users` SET `username` = :username, `job_title` = :job_title, `phone` = :phone, `address` = :address WHERE `users`.`id` = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'username' => $username,
    'job_title' => $job_title,
    'phone' => $phone,
    'address' => $address,
    'id' => $id
]);
redirect('/../users.php');


