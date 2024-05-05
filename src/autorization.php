<?php
require_once __DIR__ . "/../src/helper.php";
$email=$_POST['email'];
$password=$_POST['password'];

if ((empty($email))|| !filter_var($email,FILTER_VALIDATE_EMAIL)) {
    set_flash_message('email','Неверный формат электронной почты');
    redirect('/../page_login.php');
    exit();
}
$user=findUser($email);

if (!$user){
    set_flash_message('error','Пользователь с такой почтой не найден');
    redirect('/../page_login.php');
    exit();
}

/*if ($password !== $user['password']){
    set_flash_message('error','Ошибка в логине или пароле');
    redirect('/../page_login.php');
    exit();
}*/

if(!password_verify($password,$user['password'])){
    set_flash_message('error','Ошибка в логине или пароле');
    redirect('/../page_login.php');
    exit();
}

$_SESSION['user']['id']=$user['id'];
set_flash_message('user','добро пожаловать!');
redirect('/../users.php');