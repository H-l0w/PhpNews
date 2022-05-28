<?php

function refreshSession($id_role_){
    if($_SESSION['id'] === $_GET['id']){
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['surname'] = $_POST['surname'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['role'] = $id_role_ === '1' ? "Administrator" : 'Editor';
        $_SESSION['role_id'] = $id_role_;
        $_SESSION['email'] = $_POST['email'];
    }
}

require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
if(!isset($_GET['id'])){
    header('Location: administration_users.php');
    die();
}

require_once 'Model/Database.php';
require_once 'Model/RoleRepo.php';
require_once 'Model/UserRepo.php';

if(!LoginService::IsAdministrator() && $_SESSION['id'] != $_GET['id']){
    header('Location: index.php');
    die();
}

$db = new Database();
$repo = new RoleRepo($db);
$roles = $repo->getRoles();
$repo = new UserRepo($db);
$user = $repo->getAuthor($_GET['id']);

if (isset($_POST['id'], $_POST['name'],$_POST['surname'], $_POST['username'],
    $_POST['email'],$_POST['password'],
    $_POST['description'], $_POST['image']))
{
    require_once 'Model/Database.php';
    require_once 'Model/UserRepo.php';

    $id_role = $_POST['id_role'] ?? $_SESSION['role_id'];

    $repo = new UserRepo($db);
    if(empty($_POST['password'])){
        $repo->updateWithoutPassword(['id' => $_POST['id'],'name' => $_POST['name'], 'surname' => $_POST['surname'],
            'username' => $_POST['username'], 'email' => $_POST['email'],
            'id_role' => $id_role,
            'id_image' => $_POST['image'], 'description' => $_POST['description']]);
    }
    else{
        $repo->updateAuthor(['id' => $_POST['id'],'name' => $_POST['name'], 'surname' => $_POST['surname'],
            'username' => $_POST['username'], 'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 'id_role' => $id_role,
            'id_image' => $_POST['image'], 'description' => $_POST['description']]);
    }
    refreshSession($id_role);
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
    <title>Upravit uživatele</title>
    <link rel="stylesheet" href="Style/administration_action.css">
</head>
<body>
<div class="menu_form">
    <?php require_once 'administration_menu.php'?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Upravit uživatele - <?= $user['name']. ' '. $user['surname'] ?></h2>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <input required="required" type="text" name="name" placeholder="Jméno" value="<?= $user['name'] ?>">
                <input required="required" type="text" name="surname" placeholder="Přijímení" value=<?= $user['surname'] ?>>
                <input required="required" type="text" name="username" placeholder="Uživatelské jméno" value=<?= $user['username'] ?>>
                <input required="required" type="email" name="email" placeholder="Email" value=<?= $user['email'] ?>>
                <input type="password" name="password" placeholder="Heslo">
                <?php if (LoginService::IsAdministrator()): ?>
                    <select required="required" name="id_role" id="role">
                        <?php foreach($roles as $role):?>
                            <option <?= $user['id_role'] == $role['id'] ? 'selected=selected' : '' ?> value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <textarea required="required" name="description" id="" cols="30" rows="10" placeholder="Popis uživatele"><?= $user['description']?></textarea>
                <?php require_once 'image_picker.php'?>
                <button type="submit">Upravit uživatele</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
