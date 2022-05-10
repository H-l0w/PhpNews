<?php
session_start();
require_once 'Model/ImageRepo.php';
require_once 'Model/Database.php';
require_once 'Model/LoginService.php';
if (!isset($_GET['id'])){
    header('Location: administration_gallery.php');
    die();
}

if (!LoginService::IsCreator() && !LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}
$db = new Database();
$imageRepo = new ImageRepo($db);
$using = $imageRepo->getImageUsing($_GET['id']);

if (!$using){
    $image = $imageRepo->getImage($_GET['id']);
    if (!unlink($image['path'])){
        header('Location: administration_gallery.php?error=image_delete');
    }
    $imageRepo->deleteImage($_GET['id']);
    header('Location: administration_gallery.php');
    die();
}
else{
    header("Location: administration_gallery.php?error=image_used&id=".$_GET['id']);
    die();
}
?>