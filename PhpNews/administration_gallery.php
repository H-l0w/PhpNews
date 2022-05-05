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

$images = $repo->getImages();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="Style/administration.css">
</head>
<body>
<div class="administration">
    <?php require_once 'administration_menu.php'?>
    <div class="list">
        <div class="list_title">
            <h2>Seznam obrázků</h2>
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
        <?php endif; ?>
        <div class="images_list">
            <div class="image">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Přidat obrázek</label>
                    <input type="text" name="name" placeholder="jméno obrázku">
                    <textarea name="description" id="" cols="30" rows="10" placeholder="Popisek obrázku"></textarea>
                    <input type="file" name="add_image" accept=".png, .jpg, .jpeg" >
                    <button name="submit" value="submit" type="submit">Přidat obrázek</button>
                </form>
            </div>
            <?php foreach ($images as $image): ?>
                <div class="image">
                    <img src="<?=$image['path']?>" alt="<?=$image['name']?>">
                    <p><?=$image['name']?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>