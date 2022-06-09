<?php
if (!isset($_GET['search'])){
    header("Location: index.php");
    die();
}

require_once 'Model/Database.php';
require_once 'Model/SearchRepo.php';
require_once 'Model/PageRepo.php';  

$db = new Database();
$searchRepo = new SearchRepo($db);

$pagesNumber = $searchRepo->getNumberOfPages('%'.$_GET['search'].'%');
$actualPage = PageRepo::getActualPage($pagesNumber); 

$results = $searchRepo->search('%'.$_GET['search'].'%', $actualPage);
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
    <?php if(count($results) === 0): ?>
        <h2 class="error">Nebyly nalezeny žádné výsledky</h2>
    <?php endif; ?>
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
<div class="pagination">
    <a href="search.php?page=<?=$actualPage -1?>&search=<?=$_GET['search']?>" <?= $actualPage == 1 ? 'class="invisible"' : "" ?> ><i class="arrow left"></i></a>
    <p><?=$actualPage .' / '. $pagesNumber?></p>
    <a href="search.php?page=<?=$actualPage + 1?>&search=<?=$_GET['search']?>" <?= $actualPage == $pagesNumber ? 'class="invisible"' : "" ?>><i class="arrow right"></i></a>
</div>
</body>
</html>
