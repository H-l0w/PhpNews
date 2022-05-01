<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
if(!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

require_once 'Model/Database.php';
require_once 'Model/CategoryRepo.php';
$db = new Database();
$repo = new CategoryRepo($db);
$category = [];

if (isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['image_url'])){
    $repo->updateCategory(['id' => $_POST['id'],'name' => $_POST['name'],'description' => $_POST['description'],'image_url' => $_POST['image_url']]);
    header('Location: administration_categories.php');
    die();
}
else if(isset($_GET['id'])){
    $category = $repo->getCategory($_GET['id']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upravit kategorii</title>
    <link rel="stylesheet" href="Style/administration_action.css">
</head>
<body>
<div class="menu_form">
    <?php require_once 'administration_menu.php'?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Upravit kategorii - <?= $category['name'] ?></h2>
            </div>
            <form action="" method="post">
                <input name="id" type="hidden" value="<?= $_GET['id'] ?>">
                <input value="<?= $category['name'] ?>" type="text" name="name" required="required" placeholder="Jméno kategorie">
                <textarea required="required" name="description" id="description" cols="30" rows="10" placeholder="Popisek kategorie"><?= $category['description'] ?></textarea>
                <input value="<?= $category['image_url'] ?>" type="text" name="image_url" required="required" placeholder="Url obrázku">
                <button type="submit">Upravit kategorii</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

