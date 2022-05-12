<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Filtr</title>
    <link rel="stylesheet" href="Style/style.css">
</head>
<?php

require_once 'Model/Database.php';
require_once 'Model/ArticleRepo.php';
require_once 'Model/UserRepo.php';
require_once 'Model/CategoryRepo.php';



$db = new Database();
$repo = new ArticleRepo($db);
$articles = null;
$author = null;
$category = null;
if (isset($_GET['id_author'])){ //filter by author
    $articles = $repo->getArticlesByAuthor($_GET['id_author']);
    $repo = new UserRepo($db);
    $author = $repo->getAuthor($_GET['id_author']);
}
else if (isset($_GET['id_category'])){ //filter by category
    $articles = $repo->getArticlesByCategory($_GET['id_category']);
    $repo = new CategoryRepo($db);
    $category = $repo->getCategory($_GET['id_category']);
}
else{
    header('Location: index.php');
    die();
}
require_once 'nav_bar.php';

?>
<body>
    <?php if($category === null): ?>
        <div class="inner">
            <h1>Výpis článků pro autora: <?= $author['name']. ' '. $author['surname'] ?></h1>
            <?php require_once 'search_form.php'?>
        </div>
    <?php else: ?>
        <div class="inner">
            <h1>Výpis článků v kategorii: <?= $category['name'] ?></h1>
            <?php require_once 'search_form.php'?>
        </div>
    <?php endif; ?>

    <div class="articles">
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <div class="content">
                    <a class="title_link" href="article.php?id=<?= $article['id']?> ">
                        <img src="<?= $article['path'] ?>" alt="">
                    </a>
                    <div class="detail">
                        <h3 class="title"><a class="title_link" href="article.php?id=<?= $article['id']?>"><?= $article['title'] ?></a></h3>
                        <div class="article_preview"><?= $article['text']?></div>
                        <p>Autor: <a href="author_category.php?id_author=<?= $article['id_author'] ?>"><?= $article['name']. ' '. $article['surname']?></a></p>
                        <div class="article_info">
                            <p>Vydáno: <?=  date("j.n.Y G:i", strtotime($article['date'])); ?></p>
                            <a class="continue_reading" href="article.php?id=<?=$article['id']?>">Číst dále</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</body>
</html>