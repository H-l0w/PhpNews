<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
require_once 'Model/ArticleRepo.php';
require_once 'Model/Database.php';
require_once 'Model/CategoryRepo.php';

$db = new Database();
$repo = new ArticleRepo($db);
$author = $repo->getArticleAuthor($_GET['id']);
$repo = new CategoryRepo($db);
$assignedCategories = $repo->getCategoriesForArticle($_GET['id']);

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
if (isset($_POST['id'], $_POST['date'],$_POST['id_author'], $_POST['title'], $_POST['text'], $_POST['image'])){
    $id_author = $_POST['id_author'] ?? $_SESSION['id'];

    if (isset($_POST['visible']))
        $visible = 1;
    else
        $visible = 0;

    if (empty($_POST['date']))
        $_POST['date'] = $_POST['original_date'];

    $assignedCategoriesAfterUpdate = [];
    foreach ($_POST as $key => $item){
        if(str_contains($key, 'category')){
            $assignedCategoriesAfterUpdate[] = $item;
        }
    }

    foreach ($assignedCategories as $cat){
        if (!in_array($cat['id'], $assignedCategoriesAfterUpdate)){
            $repo->deleteCategoryAssign($_POST['id'], $cat['id']);
        }
    }

    $assignedCategoriesIds = array_column($assignedCategories, 'id');
    foreach ($assignedCategoriesAfterUpdate as $cat){
        if (!in_array($cat, $assignedCategoriesIds)){
            $repo->assignArticleToCategory($_POST['id'], $cat);
        }
    }

    $repo = new ArticleRepo($db);
    $repo->updateArticle(['id' => $_POST['id'], 'date' => $_POST['date'],'id_author' => $id_author,
        'title' => $_POST['title'], 'text' => $_POST['text'], 'visible' => $visible, 'id_image' => $_POST['image']]);
    header('Location: administration_articles.php');
    die();
}
require_once 'Model/UserRepo.php';

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
                <?php require_once 'category_picker.php';?>
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
                <label for="visible">
                    Zveřejnit
                    <input name="visible" id="visible"  type="checkbox" value="visible" <?= $article['visible'] == 1 ? 'checked' : '' ?> />
                </label>
                <?php require_once 'image_picker.php';?>
                <button type="submit">Upravit  článek</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>