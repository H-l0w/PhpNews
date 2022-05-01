<?php
session_start();
if(isset($_GET['id'])){
    require_once 'Model/LoginService.php';
    require_once 'Model/ArticleRepo.php';
    require_once 'Model/Database.php';

    $db = new Database();
    $repo = new ArticleRepo($db);
    $author = $repo->getArticleAuthor($_GET['id']);

    if(!LoginService::IsAdministrator() && (string)$_SESSION['id'] != $author){
        header('Location: index.php');
        die();
    }

    $repo->deleteArticle($_GET['id']);
    header('Location: administration_articles.php');
    die();

}
header('Location: administration_articles.php');
die();
?>