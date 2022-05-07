<?php
require_once 'Model/LoginService.php';
if(!LoginService::IsAdministrator()){
    header('Location: index.php');
    die();
}
require_once 'Model/ImageRepo.php';
require_once 'Model/Database.php';

$db = new Database();
$categoryRepo = new CategoryRepo($db);
$categories = $categoryRepo->getCategories();
$i = 0;
?>

<label for="" id="category_label">Přidat do kategorie</label>
<div class="categories">
    <?php foreach ($categories as $category): $i++;?>
        <div class="category">
            <label for="category_<?=$i?>"><?=$category['name']?>
                <input type="checkbox" id="category_<?=$i?>" name="category_<?=$i?>" value="<?=$category['id']?>">
            </label>
        </div>
    <?php endforeach;?>
</div>