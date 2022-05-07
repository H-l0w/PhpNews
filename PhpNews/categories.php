<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kategorie</title>
    <link rel="stylesheet" href="Style/categories.css">
</head>

<?php
require_once 'Model/Database.php';
require_once 'Model/CategoryRepo.php';

require_once 'nav_bar.php';

$db = new Database();

$repo = new CategoryRepo($db);
$categories = $repo->getCategories();
?>
<body>
<div class="title">
    <h1>Seznam kategorií</h1>
</div>
<div class="categories">
    <?php foreach($categories as $category): ?>
        <div class="category">
            <div class="image_title">
                <a href="author_category.php?id_category=<?= $category['id'] ?>"><img src="<?= $category['path'] ?>" alt="">
                </a>
            </div>
            <div class="description">
                <a class="name" href="author_category.php?id_category=<?= $category['id'] ?>"><h2><?= $category['name'] ?></h2></a>
                <div class="content">
                    <p><?= $category['description'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>
</div>
</body>
</html>