<?php
session_start();
if(isset($_GET['id'])){
    require_once 'Model/LoginService.php';
    if (!LoginService::IsAdministrator()){
        header('Location: index.php');
        die();
    }

    require_once 'Model/Database.php';
    require_once 'Model/UserRepo.php';
    $db = new Database();
    $repo = new UserRepo($db);
    if ($repo->canDeleteAuthor($_GET['id'])) {
        $repo->deleteAuthor($_GET['id']);
        header('Location: administration_users.php');
    }
    else {
        header('Location: administration_users.php?error=author_has_articles');
        die();
    }

}
header('Location: administration_users.php');
die();
?>