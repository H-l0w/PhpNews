<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrace - komentáře</title>
    <link rel="stylesheet" href="Style/administration.css">
</head>
<body>
<?php
require_once 'nav_bar.php';
require_once 'Model/Database.php';
require_once 'Model/CommentsRepo.php';
require_once 'Model/LoginService.php';

if (!LoginService::IsCreator() && !LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

$db = new Database();
$repo = new CommentsRepo($db);

$articles = LoginService::IsAdministrator() ? $repo->getArticlesWithComments() : $repo->getArticlesWithCommentsByAuthor($_SESSION['id']);
$comments = [];
$id_article = null;
if (isset($_GET['id_article'])){
    $comments = $repo->getCommentsForArticle($_GET['id_article']);
    $id_article = $_GET['id_article'];
}

?>
<div class="administration">
    <?php require_once 'administration_menu.php'?>
    <div class="list">
        <?php if (empty($articles)): ?>
            <div class="error">
                <h2>Nejsou k dispozici žádné komentáře</h2>
            </div>
        <?php endif;?>
        <?php if(!empty($articles)): ?>
            <div class="article_select">
                <form action="" method="get">
                    <label for="">
                        Článek
                    </label>
                    <select name="id_article" class="select_article">
                        <?php foreach ($articles as $a): ?>
                            <option <?= $id_article == $a['id'] ? 'selected' : '' ?> value="<?= $a['id'] ?>"><?= $a['title'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Zobrazit</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if (!empty($comments)): ?>
        <div class="list_title">
                <h2>Seznam komentářů</h2>
        </div>
        <div class="comments_list">
            <table>
                <td>ID</td>
                <td>Email</td>
                <td>Jméno</td>
                <td>Text</td>
                <td>Datum</td>
                <td>Akce</td>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><p><?= $comment['id'] ?></p></td>
                    <td><p><?= $comment['email'] ?></p></td>
                    <td><p><?= $comment['name'] ?></p></td>
                    <td><p><?= $comment['text'] ?></p></td>
                    <td><p><?= date("j.n.Y G:i", strtotime($comment['date'])) ?></p></td>
                    <td><a class="delete" href="delete_comment.php?id=<?= $comment['id'].'&id_article='.$_GET['id_article']?>">Odstranit</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>