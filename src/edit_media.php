<?php
require_once __DIR__ . "/helper.php";
$uploadPath = "/../upload";
$avatarPath = null;
$avatar = $_FILES['avatar'] ?? null;
$id = $_POST['id'] ?? null;
var_dump($id);

if (!empty($avatar)) {
    if ($avatar['error'] !== UPLOAD_ERR_OK) {
        set_flash_message('avatar', 'Ошибка загрузки файла');
        redirect('/../media.php');
        exit();
    }

    $types = ['image/jpeg', 'image/png'];
    if (!in_array($avatar['type'], $types)) {
        set_flash_message('avatar', 'Доступна загрузка фото только типов jpeg и png');
        redirect('/../media.php');
        exit();
    }

    if (($avatar['size'] / 1000000) >= 1) {
        set_flash_message('avatar', 'Вес фото не должен превышать 1мб');
        redirect('/../media.php');
        exit();
    }

    $avatarPath = uploadFile($avatar, 'avatar');
}

if ($avatarPath) {
    $user=newAvatar($avatarPath,$id);

    set_flash_message('avatar', 'Фото успешно добавлено');
    redirect('/../users.php');

}
?>
