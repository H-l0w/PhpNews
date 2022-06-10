<?php

require_once 'Model/LoginService.php';
if (session_status() === PHP_SESSION_NONE || session_status() === PHP_SESSION_DISABLED)
    session_start();
if(!LoginService::IsAdministrator() && !LoginService::IsCreator()){
    header('Location: index.php');
    die();
}

require_once 'Model/ImageRepo.php';
require_once 'Model/Database.php';
require_once 'Model/PageRepo.php';

$db = new Database();
$imageRepo = new ImageRepo($db);
$pagesNumber = $imageRepo->getPagesNumber();
$actualPage = PageRepo::getActualPage($pagesNumber);

$images = $imageRepo->getImages($actualPage);
$origin = "";
$id;
if (isset($article)){
    $article['path'] = $imageRepo->getImageForArticle($article['id']);
    $origin = "&id_article=$article[id]";
}
else if (isset($category)){
    $category['path'] = $imageRepo->getImageForCategory($category['id']);
    $origin = "&id_category=$category[id]";
}
else if (isset($user)){
    $user['path'] = $imageRepo->getImageForArticle($user['id']);
    $origin = "&id_user=$user[id]";
}
else{ //nothing is set - adding image, user or category
    if (isset($_GET['id_article'])){
        $article['path'] = $imageRepo->getImageForArticle($_GET['id_article']);
        $origin = "&id_article=$_GET[id_article]";
    }
    else if (isset($_GET['id_category'])){
        $category['path'] = $imageRepo->getImageForCategory($_GET['id_category']);
        $origin = "&id_category=$_GET[id_category]";
    }
    else if (isset($_GET['id_user'])){
        $user['path'] = $imageRepo->getImageForArticle($_GET['id_user']);
        $origin = "&id_user=$_GET[id_user]";
    }
}
?>
<div class="wrap" id="wrap">
    <div class="images" id="images">
        <?php foreach ($images as $image):?>
            <?php if((isset($category) && $category['path'] === $image['path']) || (isset($user) && $user['path'] === $image['path']) || (isset($article) && $article['path'] === $image['path'])):?>
                <label>
                    <input type="radio" name="image" value="<?=$image['id']?>" checked required>
                    <img src="<?=$image['path']?>" alt="<?=$image['name']?>">
                </label>
            <?php else:?>
                <label>
                    <input type="radio" name="image" value="<?=$image['id']?>" required>
                    <img src="<?=$image['path']?>" alt="<?=$image['name']?>">
                </label>
            <?php endif;?>
        <?php endforeach;?>
    </div>
    <div class="pagination">
        <i onclick="getImages(<?= $actualPage -1 ?>)" class="arrow left <?= $actualPage == 1 ? "invisible" : ""?>"></i>
        <p><?=$actualPage .' / '. $pagesNumber?></p>
        <i onclick="getImages(<?= $actualPage +1 ?>)" class="arrow right <?= $actualPage == $pagesNumber ? "invisible" : "" ?>"></i>
    </div>
    <script>
        function getImages(page){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {

                    const wrap = document.querySelector("#wrap");
                    wrap.innerHTML = this.responseText;
                    let docFrag = document.createDocumentFragment();
                    let child = wrap.removeChild(wrap.firstChild);
                    docFrag.appendChild(child);
                    wrap.parentNode.replaceChild(docFrag, wrap);
                }
            }


            <?php if(str_contains($origin, 'article')): ?>
                xmlhttp.open("GET", "image_picker.php?page=" + page + "<?= $origin?>", true);
            <?php elseif(str_contains($origin, 'category')): ?>
                xmlhttp.open("GET", "image_picker.php?page=" + page + "<?= $origin?>", true);
            <?php elseif (str_contains($origin, 'user')): ?>
                xmlhttp.open("GET", "image_picker.php?page=" + page + "<?= $origin?>", true);
            <?php else: ?>
                xmlhttp.open("GET", "image_picker.php?page=" + page, true);
            <?php endif; ?>

            xmlhttp.send();
        }
    </script>
</div>