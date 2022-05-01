<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Článek</title>
    <link rel="stylesheet" href="Style/article.css">
</head>

<body>
<?php
if (!isset($_GET['id']))
{
    header('Location: index.php');
    die();
}

require_once 'Model/Database.php';
require_once 'Model/ArticleRepo.php';
require_once 'Model/CommentsRepo.php';
require_once 'nav_bar.php';

$db = new Database();

$repo = new ArticleRepo($db);
$article = $repo->getArticle($_GET['id']);

$repo = new CommentsRepo($db);
$comments = $repo->getCommentsForArticle($article['id']);
?>

    <div class="article">
        <div class="title">
            <h1><?= $article['title'] ?></h1>
        </div>
        <div class="under_title">
            <p class="date"><?= date("j.n.Y G:i", strtotime($article['date']))?></p>
        </div>
        <div class="article_image">
            <img src="<?= $article['image_url'] ?>" alt="">
        </div>
        <div class="content">
            <p><?= $article['text'] ?></p>
        </div>
        <div class="article_info">
            <p>Autor: <a href="author_category.php?id_author=<?= $article['id_author'] ?>" class="author"><?= $article['a_name']. ' '. $article['a_surname'] ?></a></p>
            <p>Kategorie <a href="author_category.php?id_category=<?= $article['id_category'] ?>"><?= $article['name'] ?></a></p>
        </div>
    </div>
    <div class="comment_section">
        <div class="add_comment">
            <div class="form_div">
                <form action="add_comment.php" method="post">
                    <h2>Přidat komentář</h2>
                    <input type="hidden" name="id_article" value="<?= $article['id'] ?>">
                    <input placeholder="Zadejte jméno" type="text" name="name">
                    <input placeholder="Zadejte email" type="email" name="email">
                    <textarea name="comment" cols="30" rows="10" placeholder="Sem napište svůj komentář"></textarea>
                    <button type="submit">Přidat komentář</button>
                </form>
            </div>
        </div>
        <div class="comments" id="comments">
            <h2>Komentáře</h2>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment_header">
                        <h4><?= $comment['name'] ?></h4>
                        <p class="date"><?=  date("j.n.Y G:i", strtotime($comment['date'])); ?></p>
                    </div>
                    <div class="comment_text">
                        <p><?= $comment['text'] ?></p>
                    </div>
                    <!--
                    <div class="delete_comment">
                        <a href="delete_comment.php?id=<?= $comment['id'] ?>&id_article=<?= $article['id'] ?>" >Odstranit komentář</a>
                    </div>
                    -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>