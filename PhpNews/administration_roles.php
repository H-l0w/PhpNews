<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style/administration.css">
    <title>Administrace - role</title>
</head>
<body>
<?php
require_once 'Model/Database.php';
require_once 'Model/RoleRepo.php';
require_once 'Model/LoginService.php';

if (!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}

$db = new Database();
$repo = new RoleRepo($db);

$roles = $repo->getRoles();
require_once 'nav_bar.php';
?>
<div class="administration">
    <?php require_once 'administration_menu.php'?>
    <div class="list">
        <div class="role_list">
            <div class="list_title">
                <h2 id="roles">Seznam rolí</h2>
            </div>
            <div class="error">
                <?php if(isset($_GET['error']) &&$_GET['error'] == 'role_has_members'): ?>
                    <h2 id="category_contains_articles">Nelze smazat roli, kterou používají uživatelé</h2>
                <?php endif; ?>
            </div>
            <table>
                <td>ID</td>
                <td>Název</td>
                <td>Akce</td>
                <?php foreach($roles as $role): ?>
                    <tr>
                        <td><p><?= $role['id'] ?></p></td>
                        <td><p><?= $role['name'] ?></p></td>
                        <td>
                            <div class="action">
                                <a class="delete" href="delete_role.php?id=<?= $role['id'] ?>">Smazat</a>
                                <a href="update_role.php?id=<?= $role['id'] ?>">Upravit</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="add">
                <h3>
                    <a href="add_role.php">Přidat roli</a>
                </h3>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>