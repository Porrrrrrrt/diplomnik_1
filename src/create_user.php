<?php
require_once __DIR__ . "/helper.php";

$uploadPath="/../upload";
$avatarPath=null;
$username=$_POST['username'] ?? null;
$address=$_POST['address']?? null;
$phone=$_POST['phone']?? null;
$email=$_POST['email']?? null;
$job_title=$_POST['job_title']?? null;
$password=$_POST['password']?? null;
$status=$_POST['status']?? null;
$avatar=$_FILES['avatar']?? null;

$newStatus=convertStatus($status);

$user=findUser($email);

if(empty($password)){
    set_flash_message('password',"Пароль не может быть пустым!");
    //redirect('/../create_user.php');
    exit();
}
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    set_flash_message('email','Неверный формат!');
    //redirect('/../create_user.php');
    exit();
}

if(!empty($user)){
    set_flash_message('email','Указанная почта уже занята');
    redirect('/../create_user.php');
    exit();
}

if (!empty($avatar)){
    $types=['image/jpeg','image/png'];
    if(!in_array($avatar['type'],$types)){
        set_flash_message('avatar','Доступна загрузка фото только типов jpeg и png');
        redirect('/../create_user.php');
        exit();
    }
}

if (($avatar['size'] / 1000000) >= 1){
    set_flash_message('avatar','Вес фото не должен первышать 1мб');
    redirect('/../create_user.php');
}

if(!empty($avatar)){
    $avatarPath = uploadFIle($avatar,'avatar');
}
var_dump($avatarPath);








adminAddUser($email,$password,$username,$address,$phone,$job_title,$newStatus,$avatarPath);
if(empty($_SESSION['validation'])){
    set_flash_message('user','пользовтель успешно добавлен!');


    redirect('/../users.php');

}




























































/*$pdo=new PDO('mysql:host=localhost;dbname=tasks','root','');
$sql= "INSERT INTO users (username,job_title,phone,address,email,password) VALUES (:username,:job_title,:phone,:address,:email,:password)";
$stmt=$pdo->prepare($sql);
$stmt->execute([
    "username" => $username,
    "address" => $address,
    "phone" => $phone,
    "email" => $email,
    "job_title" => $job_title,
    "password" => $password
]);
$stmt->fetchAll(PDO::FETCH_ASSOC); */
//redirect("/../create_user.php");