<?php
require_once __DIR__ . "/helper.php";
$email=$_POST['email'];
$password=$_POST['password'];

$user = findUser($email);

if (empty($password)){
    set_flash_message('danger','Это поле не должно быть пустым');
    redirect('/page_register.php');
    exit();

}
if (!empty($user)){
    set_flash_message('danger','Эта почта уже используется');
    redirect('/page_register.php');
    exit();}

$newUser= addUser($email,$password);
set_flash_message('success','Регестрация выполнена');
redirect('/page_login.php');