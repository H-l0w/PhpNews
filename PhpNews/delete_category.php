<?php
    session_start();
    if(!isset($_GET['id'])){
        header('Location: administration_articles.php');
        die();
    }
    require_once 'Model/LoginService.php';

    if(!LoginService::IsAdministrator()){
        header('Location: index.php');
        die();
    }

require_once 'Model/Database.php';
require_once 'Model/CategoryRepo.php';

    $db = new Database();
    $repo = new CategoryRepo($db);
    $count = $repo->getNumArticlesForCategory($_GET['id']);
    if ($count['count'] == 0){
        $repo->deleteCategory($_GET['id']);
        header('Location: administration_categories.php');
    }
    else{
        header('Location: administration_categories.php?error=category_contains_articles');
    }
?>