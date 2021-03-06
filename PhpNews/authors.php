<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style/authors.css">
    <title>Autoři</title>
</head>

<body>
<?php
require_once 'Model/Database.php';
require_once 'Model/UserRepo.php';
require_once 'Model/ArticleRepo.php';

require_once 'nav_bar.php';

$db = new Database();

$repo = new UserRepo($db);
$authors = $repo->getAuthors();
$repo = new ArticleRepo($db);
?>
<div class="header">
    <div class="inner">
        <h1>Seznam autorů</h1>
        <?php require_once 'search_form.php'?>
    </div>
</div>
<div class="authors">
    <?php if (count($authors) === 0): ?>
        <h2 class="error">Neexistují žádní autoři</h2>
    <?php endif;?>
    <?php foreach($authors as $author): ?>
        <?php
            $articles = $repo->getArticlesByAuthor($author['id']);
        ?>
        <div class="author">
            <div class="image">
                <a href="author_category.php?id_author=<?= $author['id'] ?>"><img src="<?= $author['path'] ?>" alt=""></a>
            </div>
            <div class="detail">
                <div class="name">
                    <a href="author_category.php?id_author=<?= $author['id'] ?>"><h3><?= $author['name']. ' '. $author['surname'] ?></h3></a>
                </div>
                <div class="info">
                    <p><?= $author['description'] ?></p>
                    <p>Počet článků: <?= count($articles) ?></p>
                </div>
            </div>
        </div>
        <div class="article_list">
            <h3>Seznam článků</h3>
            <div class="content">
                <?php if (count($articles) === 0): ?>
                    <h4 class="error">Autor nepublikoval žádné články</h4>
                <?php endif;?>
                <?php foreach ($articles as $article): ?>
                    <a class="title" href="article.php?id=<?= $article['id'] ?>"><?= $article['title'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
