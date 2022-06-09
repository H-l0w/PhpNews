<?php
require_once 'nav_bar.php';
require_once 'Model/ImageRepo.php';
require_once 'Model/Database.php';
require_once 'Model/LoginService.php';

if (!LoginService::IsCreator() && !LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

$db = new Database();
$repo = new ImageRepo($db);

$pagesNumber = $repo->getPagesNumber();
$actualPage = 1;

if (isset($_GET['page']) && !empty($_GET['page'])){
    if (!is_numeric($_GET['page']))
        $actualPage = 1;
    else if ($_GET['page'] > $pagesNumber)
        $actualPage = $pagesNumber;
    else if ($_GET['page'] < 1)
        $actualPage = 1;
    else
        $actualPage = $_GET['page'];
}


if (isset($_POST['submit']) && $_POST['submit'] === 'submit'){
    if (empty($_FILES['add_image']['name'])){
        header('Location: administration_gallery.php');
        die();
    }
    $name = $_POST['name'];
    if (empty($_POST['name']))
        $name = $_FILES['add_image']['name'];

    $res = $repo->addImage($_FILES, 'add_image', $name, $_POST['description']);

    if ($res === -1){
        header('Location: administration_gallery.php?error=upload_fail');
        die();
    }
}

if (isset($_GET['search'])){
    if(empty($_GET['search'])){
        $images = $repo->getImages($actualPage);
    }
    else{
        $images = $repo->findImages('%'.$_GET['search'].'%');
    }
}
else{
    $images = $repo->getImages($actualPage, 11);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrace - galerie</title>
    <link rel="stylesheet" href="Style/administration.css">
</head>
<body>
<div class="administration">
    <?php require_once 'administration_menu.php'?>
    <div class="list">
        <div class="list_title">
            <h2>Seznam obrázků</h2>
            <form action="" method="get" class="search">
                <input type="search" name="search" placeholder="Vyhledat obrázky" value="<?=$_GET['search'] ?? ''?>">
                <button type="submit">Vyhledat</button>
            </form>
        </div>
        <?php if (empty($images)): ?>
            <div class="error">
                <h2>Nejsou k dispozici žádné obrázky</h2>
            </div>
        <?php endif;?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'upload_fail'): ?>
            <div class="error">
                <h2>Chyba při nahrávání obrázku</h2>
            </div>
        <?php endif;?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'image_delete'):?>
        <div class="error">
            <h2>Chyba při mazání obrázku</h2>
        </div>
        <?php endif;?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'image_used'): ?>
        <?php $imageUsing = $repo->getImageUsing($_GET["id"]); ?>
            <div class="error">
                <h2>Obrázek je používán</h2>
                <div class="using">
                    <h4>Použití:</h4>
                        <?php foreach ($imageUsing as $using): ?>
                            <?php if($using['what'] === 'článek'):?>
                                <a href="article.php?id=<?=$using['id']?>"><?=$using['title'].' - '. $using['what']?></a>
                            <?php elseif ($using['what'] === 'kategorie'):?>
                                <a href="author_category.php?id_category=<?=$using['id']?>"><?=$using['title'].' - '.$using['what']?></a>
                            <?php elseif ($using['what'] === 'uživatel'):?>
                                <a href="author_category.php?id_author=<?=$using['id']?>"><?=$using['title'].' - '.$using['what']?></a>
                            <?php endif;?>
                            <br>
                        <?php endforeach;?>
                </div>
            </div>
        <?php endif; ?>
        <div class="images_list" <?=empty($images) ? "style= 'justify-content: center'" : '' ?>>
            <div class="image">
                <form class="image_add" action="" method="post" enctype="multipart/form-data">
                    <h2 for="">Přidat obrázek</h2>
                    <input type="text" name="name" placeholder="jméno obrázku">
                    <textarea name="description" id="" cols="30" rows="10" placeholder="Popisek obrázku"></textarea>
                    <input type="file" name="add_image" accept=".png, .jpg, .jpeg" >
                    <button name="submit" value="submit" type="submit">Přidat obrázek</button>
                </form>
            </div>
            <?php foreach ($images as $image): ?>
                <div class="image">
                    <a href="<?=$image['path']?>" target="_blank">
                        <img src="<?=$image['path']?>" alt="<?=$image['name']?>">
                    </a>
                    <div class="name_action">
                        <p><?=$image['name']?></p>
                        <a href="delete_image.php?id=<?=$image['id']?>"" class="delete">Smazat</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <a href="administration_gallery.php?page=<?=$actualPage -1?>" <?= $actualPage == 1 ? 'class="invisible"' : "" ?> ><i class="arrow left"></i></a>
            <p><?=$actualPage .' / '. $pagesNumber?></p>
            <a href="administration_gallery.php?page=<?=$actualPage + 1?>" <?= $actualPage == $pagesNumber ? 'class="invisible"' : "" ?>><i class="arrow right"></i></a>
        </div>
    </div>
</div>
</body>
</html>