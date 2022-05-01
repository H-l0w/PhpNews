<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
if(!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

require_once 'Model/Database.php';
require_once 'Model/RoleRepo.php';
$db = new Database();
$repo = new RoleRepo($db);
$role = [];

if (isset($_POST['id'], $_POST['name'])){
    $repo->updateRole(['id' => $_POST['id'], 'name' => $_POST['name']]);
    header('Location: administration_roles.php');
    die();
}
else if(isset($_GET['id'])){
    $role = $repo->getRole($_GET['id']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upravit roli</title>
    <link rel="stylesheet" href="Style/administration_action.css">
</head>
<body>
<div class="menu_form">
    <?php require_once 'administration_menu.php'?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Upravit roli</h2>
            </div>
            <form action="" method="post">
                <input type="hidden" value="<?= $role['id'] ?>" name="id">
                <input value="<?= $role['name'] ?>" type="text" required="required" placeholder="Jméno role" name="name">
                <button type="submit">Upravit roli</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

