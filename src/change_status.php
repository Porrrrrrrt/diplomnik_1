<?php
require_once __DIR__ . "/helper.php";
$status=$_POST['status'];
$id=$_POST['id'];
$newStatus=convertStatus($status);
$user=changeStatus($newStatus,$id);
redirect('/../users.php');
