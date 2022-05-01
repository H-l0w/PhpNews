<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
if(!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

if (isset($_POST['name'], $_POST['description'], $_POST['image_url']))
{
    require_once 'Model/Database.php';
    require_once 'Model/CategoryRepo.php';
    $db = new Database();
    $repo = new CategoryRepo($db);
    $repo->addCategory(['name' => $_POST['name'], 'description' => $_POST['description'], 'image_url' => $_POST['image_url']]);
    header('Location: administration_categories.php');
    die();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Přidat kategorii</title>
    <link rel="stylesheet" href="Style/administration_action.css">
</head>
<body>
<div class="menu_form">
    <?php require_once 'administration_menu.php'?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Přidat kategorii</h2>
            </div>
            <form action="" method="post">
                <input required="required" type="text" name="name" placeholder="Jméno kategorie">
                <textarea required="required" name="description" id="description" cols="30" rows="10" placeholder="Popisek kategorie"></textarea>
                <input required="required" type="text" name="image_url" placeholder="Url obrázku kategorie">
                <button type="submit">Přidat kategorii</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
