<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="Style/administration_menu.css">
</head>
<body>
<?php
$page = basename($_SERVER['PHP_SELF']);

//fix for older php version
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
require_once 'Model/LoginService.php'
?>
<div class="menu">
    <h1>Administrace</h1>
    <ul class="admin_nav_bar">
        <li class="<?= str_contains($page, 'articles') || str_contains($page, 'article') ? 'selected' : '' ?>"><a href="administration_articles.php">Články</a></li>
        <li class="<?= str_contains($page, 'categories')  || str_contains($page, 'category')? 'selected' : '' ?>"><a href="administration_categories.php">Kategorie</a></li>
        <li class="<?= str_contains($page, 'users') || str_contains($page, 'user') ? 'selected' : '' ?>"><a href="administration_users.php">Uživatelé</a></li>
        <!-- <li class="<?= str_contains($page, 'roles') || str_contains($page, 'role') ? 'selected' : '' ?>"><a href="administration_roles.php">Role</a></li> -->
        <li class="<?= str_contains($page, 'gallery') || str_contains($page, 'gallery') ? 'selected' : '' ?>"><a href="administration_gallery.php">Galerie</a></li>
        <li class="<?= str_contains($page, 'comments') || str_contains($page, 'comment') ? 'selected' : '' ?>"><a href="administration_comments.php">Komentáře</a></li>
    </ul>
</div>
</body>
</html>
