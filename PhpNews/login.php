<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style/login.css">
    <title>Přihlášení</title>
</head>
<body>
<?php
include 'nav_bar.php';
require_once 'Model/Database.php';
require_once 'Model/LoginRepo.php';
$db = new Database();
$repo = new LoginRepo($db);
$wrong_credentials = false;

if (isset($_POST['username'], $_POST['password'])){
    $pass = $repo->getPasswordForUser($_POST['username']);

    if(empty($pass)){
        $wrong_credentials = true;
    }
    else if (!password_verify($_POST['password'], $pass['password'])){
        $wrong_credentials = true;
    }else{
        $_SESSION = $repo->login($_POST['username']);
        $_SESSION['is_logged'] = true;
        header('Location: index.php');
        die();
    }
}

?>
<div class="login">
    <div class="form_div">
        <div class="title">
            <h1>Přihlášení</h1>
        </div>
        <div class="error">
            <?php if($wrong_credentials): ?>
                <div class="error_message">
                    <h3>Chyba při přihlašování</h3>
                </div>
            <?php endif; ?>
        </div>
        <form action="" method="post">
            <input required placeholder="Uživatelské jméno nebo email" type="text" name="username">
            <input  required placeholder="Heslo" type="password" name="password">
            <button type="submit">Přihlásit</button>
        </form>
    </div>
</div>
</body>
</html>