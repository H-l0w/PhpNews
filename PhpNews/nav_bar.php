<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="Style/nav_bar.css">
</head>
<body>
<?php
session_start();
$selected = 'index';
$tabs = ['Články', 'Kategorie', 'Autoři', 'Administrace', 'Přidat článek'];
$pages = ['index.php', 'categories.php', 'authors.php', 'administration_articles.php', 'add_article.php'];
$actual_link = "$_SERVER[PHP_SELF]"; //getting page url

$slash_pos = strripos($actual_link, '/');
$file = substr($actual_link, $slash_pos + 1);

$is_logged = false;

//login check
if ($_SESSION['is_logged'] ?? null){
    if ($_SESSION['is_logged'] === true)
        $is_logged = true;
}

foreach($pages as $page){
    if ($file === $page){
        $selected = $page;
        break;
    }
}

if (str_contains($actual_link, 'administration'))
    $selected = 'administration_articles.php';
?>
<div class="nav_bar">
    <ul>
        <?php foreach ($tabs as $i => $tab): ?>
            <?php if($i > 2): break; endif;?>
                <li><a class="<?= $selected === $pages[$i] ? 'selected' : '' ?>" href="<?= $pages[$i] ?>"><?= $tabs[$i] ?></a></li>
        <?php endforeach; ?>
        <?php if($is_logged === true): ?>
            <li><a class="<?= $selected === $pages[$i] ? 'selected' : '' ?>" href="administration_articles.php">Administrace</a></li>
            <li><a class="<?= $selected === $pages[$i + 1] ? 'selected' : '' ?>" href="add_article.php">Přidat článek</a></li>
        <?php endif; ?>
        <div class="login_logout">
            <?php if($is_logged): ?>
                <li><a href="update_user.php?id=<?= $_SESSION['id'] ?>"><?= $_SESSION['name']. ' '. $_SESSION['surname']?></a></li>
                <li><a href="logout.php">Odhlásit</a></li>
            <?php else: ?>
                <li><a href="login.php">Přihlásit</a></li>
                <li><a href="register.php">Zaregistrovat</a></li>
            <?php endif; ?>
        </div>
    </ul>
</div>
</body>
</html>