<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Přehled článků</title>
    <link rel="stylesheet" href="Style/style.css">
</head>

<?php
require_once 'Model/Database.php';
require_once 'Model/ArticleRepo.php';

$db = new Database();

$repo = new ArticleRepo($db);
$articles = $repo->getArticles();
$i = 0;
?>

<body>
    <?php require_once 'nav_bar.php'?>
    <div class="introduction">
        <div class="inner">
            <h1>Nejnovější články</h1>
            <?php require_once 'search_form.php'?>
        </div>
    </div>
    <div class="latest">
        <?php foreach ($articles as $key => $article): if ($key > 0) break ?>
            <div class="latest_article">
                <div class="info">
                    <a href="article.php?id=<?= $article['id'] ?>"><?= $article['title'] ?></a>
                    <a style="font-size: 100%" class="continue_reading_latest" href="article.php?id=<?=$article['id']?>">Číst dále</a>
                </div>
                <div class="image">
                    <a href="article.php?id=<?= $article['id'] ?>">
                        <img src="<?= $article['path'] ?>" alt="">
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="four_articles">
        <?php foreach($articles as $key => $article): if($key < 1) continue; if ($key == 5) break;?>
            <div class="four_articles_article">
                <a href="article.php?id=<?= $article['id'] ?>"><img src="<?= $article['path'] ?>" alt=""></a>
                <h4 class="title"><a class="title_link" href="article.php?id=<?= $article['id']?>"><?= $article['title'] ?></a></h4>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="articles">
        <?php foreach ($articles as $key => $article): if ($key < 5 ) continue ;?>
                <div class="article">
                    <div class="content">
                        <a class="title_link" href="article.php?id=<?= $article['id']?> ">
                            <img src="<?= $article['path'] ?>" alt="">
                        </a>
                        <div>
                            <h3 class="title"><a class="title_link" href="article.php?id=<?= $article['id']?>"><?= $article['title'] ?></a></h3>
                            <div class="article_preview"><?= $article['text']?></div>
                                <p>Autor: <a href="author_category.php?id_author=<?= $article['id_author'] ?>"><?= $article['a_name']. ' '. $article['a_surname']?></a></p>
                            <div class="info">
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