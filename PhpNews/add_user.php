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
$roles = $repo->getRoles();

if (isset($_POST['name'],$_POST['surname'], $_POST['username'],
          $_POST['email'],$_POST['password'], $_POST['id_role'],
          $_POST['image_url'] ,$_POST['description']))
{
    require_once 'Model/Database.php';
    require_once 'Model/UserRepo.php';
    $repo = new UserRepo($db);
    $repo->addAuthor(['name' => $_POST['name'], 'surname' => $_POST['surname'],
        'username' => $_POST['username'], 'email' => $_POST['email'],
        'password' => hash('sha256', $_POST['password']), 'id_role' => $_POST['id_role'],
        'image_url' => $_POST['image_url'], 'description' => $_POST['description']]);
    header('Location: administration_users.php');
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
    <title>Přidat uživatele</title>
    <link rel="stylesheet" href="Style/administration_action.css">
</head>
<body>
<div class="menu_form">
    <?php require_once 'administration_menu.php' ?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Přidat uživatele</h2>
            </div>
            <form action="" method="post">
                <input required="required" type="text" name="name" placeholder="Jméno">
                <input required="required" type="text" name="surname" placeholder="Přijímení">
                <input required="required" type="text" name="username" placeholder="Uživatelské jméno">
                <input required="required" type="email" name="email" placeholder="Email">
                <input required="required" type="text" name="password" placeholder="Heslo">
                <select required="required" name="id_role" id="role">
                    <option value="" disabled="disabled">Vyberte uživatelskou roli</option>
                    <?php foreach($roles as $role): ?>
                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea required="required" name="description" id="" cols="30" rows="10" placeholder="Popis uživatele"></textarea>
                <input required="required" type="text" name="image_url" placeholder="Url obrázku">
                <button type="submit">Přidat uživatele</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>