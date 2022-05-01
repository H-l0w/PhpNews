<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style/administration.css">
    <title>Document</title>
</head>
<?php
require_once 'Model/Database.php';
require_once 'nav_bar.php';
require_once 'Model/ArticleRepo.php';
require_once 'Model/UserRepo.php';
require_once 'Model/CategoryRepo.php';
require_once 'Model/CommentsRepo.php';
require_once 'Model/RoleRepo.php';

if(!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

$db = new Database();
$repo_article = new ArticleRepo($db);
$repo_authors = new UserRepo($db);
$repo_categories = new CategoryRepo($db);
$repo_comments = new CommentsRepo($db);
$repo_roles = new RoleRepo($db);

$articles = $repo_article->getAllArticles();
$authors = $repo_authors->getAuthors();
$categories = $repo_categories->getCategories();
$comments = $repo_comments->getComments();
$roles = $repo_roles->getRoles();
?>
<body>
<div class="administration">
    <?php require_once 'administration_menu.php'?>

</div>
</body>
</html>