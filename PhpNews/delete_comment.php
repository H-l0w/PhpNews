<?php
session_start();
if(!isset($_GET['id'], $_GET['id_article'])){
    header('Location: administration_comments.php');
    die();
}

require_once 'Model/Database.php';
require_once 'Model/CommentsRepo.php';
require_once 'Model/ArticleRepo.php';

$db = new Database();
$repo = new ArticleRepo($db);
$id_author = $repo->getArticleAuthor($_GET['id_article']);

if ($id_author !== $_SESSION['id']){
    header('Location: administration_comments.php');
    die();
}

$repo = new CommentsRepo($db);
$repo->deleteComment($_GET['id']);
header('Location: administration_comments.php?id_article='.$_GET['id_article']);
?>