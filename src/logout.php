<?php
require_once __DIR__ . "/../src/helper.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    logOut();
}
redirect('/../page_login.php');