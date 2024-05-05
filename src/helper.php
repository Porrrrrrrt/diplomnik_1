<?php
session_start();
function redirect(string $path)
{
    header("Location: $path");
    exit();
}

function set_flash_message($name,$message):string
{
   return $_SESSION['validation'][$name]=$message;
}

function hasValidationError()
{
    if(isset($_SESSION['validation'])){
        return true;
    }
    return false;
}
function validationErrorAttr(string $fieldName,$status): string
{
    return isset($_SESSION['validation'][$fieldName]) ? "alert alert-{$status}" : '';
}

function validationErrorMessage(string $fieldName): string
{
    $message = $_SESSION['validation'][$fieldName] ?? '';
    unset($_SESSION['validation'][$fieldName]);
    return $message;
}

function convertStatus(string $status) :string
{
    if ($status=="Онлайн"){
        return $status="success";
    }
    elseif ($status=="Не беспокоить"){
        return $status="danger";
    }
    elseif ($status=="Отошел"){
        return $status="dark";
    }
}

function changeStatus($newStatus,$id)
{
    $pdo = new PDO('mysql:host=localhost;dbname=tasks', 'root', '');
    $sql = "UPDATE `users` SET `status` = :status WHERE `users`.`id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'status' => $newStatus,
        'id' => $id
    ]);

}
function findUser(string $email):array|bool
{
    $pdo=new PDO('mysql:host=localhost;dbname=tasks','root','');
    $sql="SELECT * FROM users WHERE (email =:email)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(['email'=>$email]);
    return $user=$stmt->fetch(PDO::FETCH_ASSOC);
}

function addUser($email,$password):array|string
{
    $pdo=new PDO('mysql:host=localhost;dbname=tasks','root','');
    $sql="INSERT INTO users (email,password) VALUES (:email,:password)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(['email'=>$email, 'password' => password_hash($password,PASSWORD_DEFAULT)]);
    return $newUser=$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function allUsers()
{
    $pdo=new PDO('mysql:host=localhost;dbname=tasks','root','');
    $sql="SELECT * FROM users";
    $stmt=$pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function logOut()
{
    unset($_SESSION['user']['id']);
}
function is_logged_in()
{
    if (isset($_SESSION['user']['id'])) {
        return true;
    }
    return false;
}
function is_not_logged_in()
{
    return !is_logged_in();
}
function get_authenticated_user()
{
    if(is_logged_in()){
        return $_SESSION['user'];
    }
    return null;
}
function currentUser(?string $id)
{
    if ($id === null) {
        return null; // или обработать какую-то ошибку или логировать её
    }
    try {
    $pdo = new PDO('mysql:host=localhost;dbname=tasks','root','');
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Подключение не удалось: ' . $e->getMessage());
    }
}
function is_admin($user)
{
    if($user['role']==="admin"){
        return true;
    }
    return false;
}

function is_user_owner($id,$currentUser)
{
    if($id===$currentUser['id']){
        return true;
    }
    return false;
}
function adminAddUser($email,$password,$username,$address,$phone,$job_title,$status,$avatar):array|string
{
    $pdo=new PDO('mysql:host=localhost;dbname=tasks','root','');
    $sql="INSERT INTO users (email,password,username,address,phone,job_title,status,avatar) VALUES (:email,:password,:username,:address,:phone,:job_title,:status,:avatar)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(['email'=>$email,'address'=>$address,'phone'=> $phone, 'password' => password_hash($password,PASSWORD_DEFAULT) ,'username' => $username,'job_title' => $job_title, 'status'=>$status,'avatar'=>$avatar]);
    return $newUser=$stmt->fetchAll(PDO::FETCH_ASSOC);
}

function uploadFile(array $file, string $prefix = ''): string
{
    $uploadPath = __DIR__ . '/../uploads';

    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = $prefix . '_' . time() . ".$ext";

    if (!move_uploaded_file($file['tmp_name'], "$uploadPath/$fileName")) {
        die('Ошибка при загрузке файла на сервер');
    }

    return "uploads/$fileName";
}

function newAvatar($avatarPath,$id)
{
    $pdo = new PDO('mysql:host=localhost; dbname=tasks', 'root', '');
    $sql = "UPDATE `users` SET `avatar` = :avatar WHERE `users`.`id` = :id;";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['avatar' => $avatarPath, 'id' => $id]);
}