<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
require_once 'Model/ArticleRepo.php';
require_once 'Model/Database.php';

$db = new Database();
$repo = new ArticleRepo($db);
$author = $repo->getArticleAuthor($_GET['id']);

if(!LoginService::IsAdministrator()){
    if(!LoginService::IsAdministrator() && (string)$_SESSION['id'] != $author){
        header('Location: index.php');
        die();
    }
}

if (!isset($_GET['id'])){
    header('Location: administration_articles.php');
    die();
}

if (isset($_POST['id'], $_POST['date'],$_POST['id_category'], $_POST['title'], $_POST['text'], $_POST['image_url'])){

    $id_author = $_POST['id_author'] ?? $_SESSION['id'];

    $visible = 0;
    if (isset($_POST['visible']))
        $visible = 1;
    if (empty($_POST['date']))
        $_POST['date'] = $_POST['original_date'];

    $repo = new ArticleRepo($db);
    $repo->updateArticle(['id' => $_POST['id'], 'date' => $_POST['date'],'id_author' => $id_author, 'id_category' => $_POST['id_category'],
        'title' => $_POST['title'], 'text' => $_POST['text'], 'visible' => $visible, 'image_url' => $_POST['image_url']]);
    header('Location: administration_articles.php');
    die();
}
require_once 'Model/CategoryRepo.php';
require_once 'Model/UserRepo.php';

$repo = new CategoryRepo($db);
$categories = $repo->getCategories();
$repo = new UserRepo($db);
$users = $repo->getAuthors();
$repo = new ArticleRepo($db);
$article = $repo->getArticle($_GET['id']);
$date = date("d/m/Y G:i", strtotime($article['date']));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upravit článek</title>
    <link rel="stylesheet" href="Style/administration_action.css">
    <script src="tinymce/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: '#article_content'
        });
    </script>
</head>
<body>
<div class="menu_form">
    <?php require_once  'administration_menu.php' ?>
    <div class="main">
        <div class="form_div">
            <div class="title">
                <h2>Upravit článek</h2>
            </div>
            <form action="" method="post">
                <input type="hidden" name="original_date" value="<?= $article['date'] ?>">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <input type="text" name="title" required placeholder="Titulek článku" value="<?= $article['title'] ?>">
                <textarea style="height: 700px" class="article_content" name="text" id="article_content" cols="30" rows="10" placeholder="Text článku"><?= $article['text'] ?></textarea>
                <select name="id_category" id="article_category" required>
                    <option value="" disabled selected>Vyberte kategorii</option>
                    <?php foreach($categories as $category): ?>
                        <option <?= $category['id'] == $article['id_category'] ? 'selected' : '' ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (LoginService::IsAdministrator()) : ?>
                    <label for="id_author">Vyberte autora</label>
                    <select name="id_author" id="id_author">
                        <option value="" disabled selected>Vyberte autora</option>
                        <?php foreach ($users as $user): ?>
                            <option <?= $user['id'] == $article['id_author'] ? 'selected' : '' ?> value="<?= $user['id'] ?>"><?= $user['name'].' '.$user['surname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <label for="date">Čas zveřejnění</label>
                <input name="date" type="datetime-local"  value="<?= $date ?>" >
                <label for="">
                    <input name="visible" id="visible"  type="checkbox" value="visible" <?= $article['visible'] == 1 ? 'checked' : '' ?> />
                </label>
                <input type="text" name="image_url" placeholder="Url obrázku" value="<?= $article['image_url'] ?>">
                <button type="submit">Upravit  článek</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>