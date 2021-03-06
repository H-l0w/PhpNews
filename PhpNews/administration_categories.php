<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrace - kategorie</title>
    <link rel="stylesheet" href="Style/administration.css">
</head>
<body>
<?php
require_once 'nav_bar.php';
require_once 'Model/Database.php';
require_once 'Model/CategoryRepo.php';
require_once 'Model/LoginService.php';


$db = new Database();
$repo = new CategoryRepo($db);
if (isset($_GET['search'])){
    if (empty($_GET['search'])){
        $categories = $repo->getCategories();
    }
    else{
        $categories = $repo->findCategories('%'.$_GET['search'].'%');
    }
}
else{
    $categories = $repo->getCategories();
}
?>
<div class="administration">
    <?php require_once 'administration_menu.php'?>
    <div class="list">
        <div class="category_list">
            <div class="list_title">
                <h2 id="categories">Seznam kategorií</h2>
                    <form action="" method="get" class="search">
                        <input type="search" name="search" placeholder="Vyhledat kategorii" value="<?=$_GET['search'] ?? ''?>">
                        <button type="submit">Vyhledat</button>
                    </form>
            </div>
            <div class="error">
                <?php if(isset($_GET['error']) &&$_GET['error'] == 'category_contains_articles'): ?>
                    <h2 id="category_contains_articles">Nelze smazat kategorii, která obsahuje články</h2>
                <?php endif; ?>
            </div>
            <div class="table_wrapper">
                <table>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Popis</th>
                    <th>Obrázek</th>
                    <?php if(LoginService::IsAdministrator()): ?>
                        <th>Akce</th>
                    <?php endif; ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><p><?= $category['id'] ?></p></td>
                            <td><p><?= $category['name'] ?></p></td>
                            <td><p><?= $category['description'] ?></p></td>
                            <td><a href="<?= $category['path'] ?>">Zobrazit obrázek</a></td>
                            <?php if(LoginService::IsAdministrator()):?>
                                <td>
                                    <div class="action">
                                        <a class="delete" href="delete_category.php?id=<?= $category['id'] ?>">Smazat</a>
                                        <a href="update_category.php?id=<?= $category['id'] ?>">Upravit</a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php if(LoginService::IsAdministrator()): ?>
                <div class="add">
                    <h3>
                        <a href="add_category.php">Přidat kategorii</a>
                    </h3>
                </div>
            <?php endif;?>
        </div>
</div>
</body>
</html>