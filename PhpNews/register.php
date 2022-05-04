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
<script>
    function checkPassword() {
        const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
        let password = document.getElementById("pass").value;
        let check = document.getElementById("pass_check").value;

        if (password === "" || check === "") {
            document.getElementById("e").innerHTML = "Zadejte heslo";
            return false;
        }

        if (password !== check) {
            document.getElementById("e").innerHTML = "Hesla se neshodují"
            return false;
        }

        if (password.length > 32){
            document.getElementById("e").innerHTML = "Heslo je příliš dlouhé";
            return false;
    }

        if (!pattern.test(password)){
            console.log("neproslo");
            document.getElementById("e").innerHTML = "Heslo ja málo složité"
            return false;
        }
        return true;
    }
</script>
<body>
<?php
include 'nav_bar.php';
require_once 'Model/LoginRepo.php';
require_once 'Model/Database.php';
require_once 'Model/ImageRepo.php';

if(isset($_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['description'])){

    $db = new Database();
    $repo = new LoginRepo($db);
    $userRepo = new UserRepo($db);
    $image_repo = new ImageRepo($db);

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
        <input placeholder="Heslo" type="password" name="password" id="pass" required>
        <input placeholder="Potvrdit heslo" type="password" id="pass_check" required>
        <input type="file" name="profile_image" id="profile_image" accept=".png, .jpg, .jpeg" required>
        <textarea name="description" id="" cols="30" rows="10" placeholder="Popisek uživatele" required></textarea>

        <button type="submit">Registrovat</button>
    </form>
</div>
</body>
</html>