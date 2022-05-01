<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrace - uživatelé</title>
    <link rel="stylesheet" href="Style/administration.css">
</head>
<body>
<?php
require_once 'Model/Database.php';
require_once 'Model/UserRepo.php';

$db = new Database();
$repo = new UserRepo($db);

$users = $repo->getAuthors();
require_once 'nav_bar.php';
?>
<div class="administration">
    <?php require_once 'administration_menu.php' ?>
    <div class="list">
        <div class="author_list">
            <div class="list_title">
                <h2 id="users">Seznam uživatelů</h2>
            </div>
            <div class="error">
                <?php if(isset($_GET['error']) &&$_GET['error'] == 'author_has_articles'): ?>
                    <h2 id="category_contains_articles">Nelze smazat autora, který publikoval články</h2>
                <?php endif; ?>
            </div>
            <table>
                <th>ID</th>
                <th>Uživatelské jméno</th>
                <th>Email</th>
                <th>Jméno</th>
                <th>Přijímení</th>
                <th>Role</th>
                <th>Obrázek</th>
                <?php if(LoginService::IsAdministrator()) :?>
                    <th>Akce</th>
                <?php endif; ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><p><?= $user['id'] ?></p></td>
                        <td><p><?= $user['username'] ?></p></td>
                        <td><p><?= $user['email'] ?></p></td>
                        <td><p><?= $user['name'] ?></p></td>
                        <td><p><?= $user['surname'] ?></p></td>
                        <td><p><?= $user["role_description"] ?></p></td>
                        <td><a href="<?= $user['image_url'] ?>">zobrazit obrázek</a></td>
                        <?php if(LoginService::IsAdministrator()) :?>
                            <td>
                                <div class="action">
                                    <a class="delete" href="delete_user.php?id=<?= $user['id'] ?>">Smazat</a>
                                    <a href="update_user.php?id=<?= $user['id'] ?>">Upravit</a>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php if(LoginService::IsAdministrator()) :?>
                <div class="add">
                    <h3>
                        <a href="add_user.php">Přidat uživatele</a>
                    </h3>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

</body>
</html>