<?php
if (!isset($_GET['origin'], $_GET['search'])){
    header("Location: index.php");
    die();
}

if (empty($_GET['search'])){
    header("Location: ".$_GET['origin']);
    die();
}

require_once 'Model/Database.php';
require_once 'Model/SearchRepo.php';

$db = new Database();
$searchRepo = new SearchRepo($db);
$results = $searchRepo->search('%'.$_GET['search'].'%');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vyhledávání</title>
    <link rel="stylesheet" href="Style/style.css">
</head>
<body>
<?php require_once 'nav_bar.php'; ?>
<div class="inner">
    <h1>Výsledky hledání: <?=$_GET['search']?></h1>
    <?php require_once 'search_form.php'?>
</div>
<div class="results">
    <?php foreach ($results as $res): ?>
        <?php
            if ($res['type'] === 'Článek'){
                $href = 'article.php?id='.$res['id'];
                $hrefType = 'index.php';
            }
            if ($res['type'] === 'Kategorie'){
                $href = 'author_category.php?id_category='.$res['id'];
                $hrefType = 'categories.php';
            }
            if ($res['type'] === 'Autor'){
                $href = 'author_category.php?id_author='.$res['id'];
                $hrefType = 'authors.php';
            }
        ?>
        <div class="result">
            <div class="content">
                <a href="<?=$href?>">
                    <img src="<?=$res['path']?>" alt="<?=$res['name']?>">
                </a>
                <div class="detail">
                    <div class="title_type">
                        <h3 class="title"><a href="<?=$href?>"><?=$res['name']?></a></h3>
                        <a href="<?=$hrefType?>">
                            <p class="type"><?=$res['type']?></p>
                        </a>
                    </div>
                    <div class="text_preview"><?=$res['detail']?></div>
                </div>
            </div>
        </div>
    <?php  endforeach; ?>
</div>
</body>
</html>
