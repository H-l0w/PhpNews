<?php
require_once 'Model/LoginService.php';
if(!LoginService::IsAdministrator() && !LoginService::IsCreator()){
    header('Location: index.php');
    die();
}
require_once 'Model/ImageRepo.php';
require_once 'Model/Database.php';
$db = new Database();
$imageRepo = new ImageRepo($db);
$images = $imageRepo->getImages();
?>

<label for="">Vyberte obrázek</label>
<div class="images">
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