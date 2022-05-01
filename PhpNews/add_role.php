<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
if(!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

if (isset($_POST['name']))
{
    require_once 'Model/Database.php';
    require_once 'Model/RoleRepo.php';
    $db = new Database();
    $repo = new RoleRepo($db);

    $repo->addRole(['name' => $_POST['name']]);
    header('Location: administration_roles.php');
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
    <title>Přidat roli</title>
    <link rel="stylesheet" href="Style/administration_action.css">
</head>
<body>
<div class="menu_form">
    <?php require_once 'administration_menu.php'?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Přidat roli</h2>
            </div>
            <form action="" method="post">
                <input type="text" required="required" placeholder="Jméno role" name="name">
                <button type="submit">Přidat roli</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
