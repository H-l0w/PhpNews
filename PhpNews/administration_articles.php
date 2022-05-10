<?php require_once 'nav_bar.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrace - články</title>
    <link rel="stylesheet" href="Style/administration.css">
</head>
<body>
<?php
require_once 'Model/Database.php';
require_once 'Model/ArticleRepo.php';
require_once 'Model/LoginService.php';

if (!LoginService::IsAdministrator() && !LoginService::IsCreator()){
    header('Location: index.php');
    die();
}

$db = new Database();
$repo = new ArticleRepo($db);

if (isset($_GET['search'])){
    if (empty($_GET['search'])){
        $articles = $repo->getAllArticles();
    }
    else{
        $articles = $repo->findArticles('%'.$_GET['search'].'%');
    }
}
else{
    $articles = $repo->getAllArticles();
}
?>

<div class="administration">
    <?php require_once 'administration_menu.php'?>
    <div class="list">
        <div class="list_title">
            <h2 id="articles">Seznam článků</h2>
            <form action="" method="get" class="search">
                <input type="search" name="search" placeholder="Vyhledat článek" value="<?=$_GET['search'] ?? ''?>">
                <button type="submit">Vyhledat</button>
            </form>
        </div>
        <table>
            <th>ID</th>
            <th>Autor</th>
            <th>Datum publikace</th>
            <th>Titulek</th>
            <th>Viditelnost</th>
            <th>Akce</th>
            <?php foreach ($articles as $key => $article): ?>
                <tr>
                    <td><?= $article['id'] ?></td>
                    <td>
                        <a href="author_category.php?id_author=<?= $article['id_author'] ?>">
                            <?= $article['a_name']. ' '. $article['a_surname']?></a>
                    </td>
                    <td>
                        <p class="date"><?=  date("j.n.Y G:i", strtotime($article['date'])); ?></p>
                    </td>
                    <td>
                        <a href="article.php?id=<?= $article['id'] ?>"><?= $article['title'] ?></a>
                    </td>
                    <td>
                        <p><?= $article['visible'] == true ? 'Viditelné' : 'Skryté' ?></p>
                    </td>
                    <td>
                        <?php if(LoginService::IsAdministrator() || $_SESSION['id'] == $article['id_author']):?>
                            <div class="action">
                                <a class="delete" href="delete_article.php?id=<?=$article['id']?>">Smazat</a>
                                <a href="update_article.php?id=<?=$article['id']?>">Upravit</a>
                            </div>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
        <div class="add">
            <h3>
                <a href="add_article.php">Přidat článek</a>
            </h3>
        </div>
    </div>
</div>
</div>
</body>
</html>