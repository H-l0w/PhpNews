<?php
require_once 'nav_bar.php';
require_once 'Model/LoginService.php';
if(!LoginService::IsCreator() && !LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}
require_once 'Model/Database.php';
$db = new Database();

if (isset($_POST['date'], $_POST['title'], $_POST['text'], $_POST['image'])){
    require_once 'Model/ArticleRepo.php';
    require_once 'Model/CategoryRepo.php';
    if(empty($_POST['date']))
        $_POST['date'] = date("Y-m-d H:i:s");

    $visible = 0;
    if (isset($_POST['visible']))
        $visible = 1;

    $id_author = $_POST['id_author'] ?? $_SESSION['id'];

    $repo = new ArticleRepo($db);
    $visible = $_POST['visible'] == 'visible' ? 1 : 0;

    $categoryRepo = new CategoryRepo($db);

    $idArticle = $repo->addArticle(['date' => $_POST['date'],'id_author' => $id_author, 'title' => $_POST['title'],
                       'text' => $_POST['text'], 'visible' => $visible, 'id_image' => $_POST['image']]);

    foreach ($_POST as $key => $item){
        if(str_contains($key, 'category')){
            $categoryRepo->assignArticleToCategory($idArticle, $item);
        }
    }
    header('Location: administration_articles.php');
    die();
}
require_once 'Model/CategoryRepo.php';
require_once 'Model/UserRepo.php';
$repo = new CategoryRepo($db);
$repo = new UserRepo($db);
$users = $repo->getAuthors();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Přidat článek</title>
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
                <h2>Přidat článek</h2>
            </div>
            <form action="" method="post">
                <input type="text" name="title" required placeholder="Titulek článku" maxlength="75">
                <textarea style="height: 700px" class="article_content" name="text" id="article_content" cols="30" rows="10" placeholder="Text článku"></textarea>
                <?php require_once 'category_picker.php';?>
                <?php if(LoginService::IsAdministrator()): ?>
                    <label for="id_author">Vyberte autora</label>
                    <select name="id_author" id="id_author">
                        <option value="" disabled selected>Vyberte autora</option>
                        <?php foreach ($users as $user): ?>
                            <option <?= $user['id'] == $_SESSION['id'] ? 'selected' : '' ?> value="<?= $user['id'] ?>"><?= $user['name'].' '.$user['surname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <label for="date">Čas zveřejnění</label>
                <input name="date" type="datetime-local" id="date" value=<?php echo date('Y-m-d\TH:i:s'); ?>>
                <label for="visible"  style="word-wrap:break-word">
                    <input name="visible" id="visible"  type="checkbox" value="visible" />Zveřejnit
                </label>
                <?php require_once 'image_picker.php';?>
                <button type="submit">Přidat článek</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>