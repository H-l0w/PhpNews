<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style/login.css">
    <title>Document</title>
</head>
<body>
<?php
include 'nav_bar.php';
require_once 'Model/LoginRepo.php';
require_once 'Model/Database.php';
require_once 'Model/ImageRepo.php';
require_once 'Model/UserRepo.php';

if(isset($_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['description'], $_POST['pass_check'])){

    $db = new Database();
    $repo = new LoginRepo($db);
    $userRepo = new UserRepo($db);
    $image_repo = new ImageRepo($db);

    if ($_POST['password'] !== $_POST['pass_check']){
        header('Location: register.php?error=password_does_not_match');
        die();
    }

    if (preg_match("/(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,32}/", $_POST['password']) === 0){
        header('Location: register.php?error=password_policy');
        die();
    }

    if($userRepo->usernameExists($_POST['username']))
    {
        header('Location: register.php?error=user_exists');
        die();
    }
    else if ($userRepo->emailExists($_POST['email'])){
        header('Location: register.php?error=user_exists');
        die();
    }
    else{
        //not exists -> can be added
        $res = $image_repo->addImage($_FILES, 'profile_image', $_POST['username'], null);
        if ($res === -1){
            header('Location: register.php?error=upload_fail');
            die();
        }

        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $repo->register(['name' => $_POST['name'], 'surname' => $_POST['surname'],
            'username' => $_POST['username'], 'email' => $_POST['email'],
            'password' => $pass,
            'id_image' => $res, 'description' => $_POST['description']]);
        $login = $repo->login($_POST['username'], $pass);
        $_SESSION = $login;
        $_SESSION['is_logged'] = true;
        header('Location: index.php');
        die();
    }
}
?>
<div class="register">
    <div class="form_div" id="register" style="margin: 0 auto 0">
        <div class="title">
            <h1>Registrace</h1>
        </div>
        <div class="error">
            <div class="error_message">
                <h3 id="e">
                    <?php if(isset($_GET['error'])): ?>
                        <?php if($_GET['error'] === 'user_exists'): ?>
                            Zadaný uživatel již existuje
                        <?php elseif($_GET['error'] === 'upload_fail'): ?>
                            Chyba při nahrávání obrázku
                        <?php elseif($_GET['error'] === 'password_does_not_match'): ?>
                            Zadaná hesla se neshodojí
                        <?php elseif($_GET['error'] === 'password_policy'): ?>
                            Heslo nesplňuje požadavky
                        <?php endif;?>
                    <?php endif;?>
                </h3>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Jméno" name="name" required id="name">
            <input type="text" placeholder="Příjímení" required name="surname">
            <input type="text" placeholder="Uživatelské jméno" required name="username">
            <input type="email" placeholder="Email" required name="email">
            <input placeholder="Heslo" type="password" name="password" id="pass" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,32}$" title="Heslo musí obsahovat velké a malé písmeno a číslici">
            <input placeholder="Potvrdit heslo" name="pass_check" type="password" id="pass_check" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Heslo musí obsahovat velké a malé písmeno a číslici">
            <input type="file" name="profile_image" id="profile_image" accept=".png, .jpg, .jpeg" required>
            <textarea name="description" id="" cols="30" rows="10" placeholder="Popisek uživatele" required></textarea>

            <button type="submit">Registrovat</button>
        </form>
    </div>
</div>
</body>
</html>