<?php
if(!isset($_POST['name'], $_POST['email'], $_POST['comment'], $_POST['id_article'])){
    header('Location: article.php?id='. $_POST['id_article']);
    die();
}

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['comment'])){
    header('Location: article.php?id='. $_POST['id_article']);
    die();
}

require_once 'Model/Database.php';
require_once 'Model/CommentsRepo.php';

$db = new Database();
$repo = new CommentsRepo($db);
$repo->addComment(['id_article' => $_POST['id_article'], 'name' => $_POST['name'], 'email' => $_POST['email'], 'text' => $_POST['comment']]);
header('Location: article.php?id='. $_POST['id_article'].'#comments');
?>
