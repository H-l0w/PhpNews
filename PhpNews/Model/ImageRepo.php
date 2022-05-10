<?php

class ImageRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    private function addImageToDatabase($name){
        $sql = 'INSERT INTO images (id, name, path) values (default, :name, :path)';
        return $this->db->insert($sql, ['name' => $name, 'path' => 'Images/'.$name]);
    }

    private function addImageToDatabaseDescription($name, $description){
        $sql = 'INSERT INTO images values (default, :name, :description, :path)';
        return $this->db->insert($sql, ['name' => $name, 'description' => $description, 'path' => 'Images/'.$name]);
    }

    public function getImages(){
        $sql = 'SELECT * FROM images';
        return $this->db->select($sql);
    }

    public function findImages($search){
        $sql = 'SELECT * FROM images WHERE name LIKE :search OR description LIKE :search';
        return $this->db->selectWithParams($sql, ['search' => $search]);
    }

    public function getImage($id){
        $sql = 'SELECT * FROM images WHERE id = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function getImageUsing($id){
        $sql = "SELECT a.title, 'článek' as what, a.id FROM articles a where a.id_image = :id
                UNION
                SELECT c.name, 'kategorie' as what, c.id FROM categories c where c.id_image = :id
                UNION
                SELECT u.username, 'uživatel' as what, u.id FROM users u where u.id_image = :id
                ORDER BY what";
        return $this->db->selectWithParams($sql, ['id' => $id]);
    }

    public function deleteImage($id){
        $sql = 'DELETE FROM images WHERE id = :id';
        $this->db->delete($sql,$id);
    }

    public function addImage($files, $imageNameInFiles, $imageNameToStore, $description){
        $target_dir = "Images/";
        $extension = strtolower(pathinfo($files[$imageNameInFiles]['name'],PATHINFO_EXTENSION));

        $target_file = "";
        if (str_contains($imageNameToStore, '.png') || str_contains($imageNameToStore, '.jpg') || str_contains($imageNameToStore, '.jpeg')){
            $target_file = $target_dir .$imageNameToStore;
        }
        else{
            $target_file = $target_dir .$imageNameToStore.'.'.$extension;
        }

        $check = getimagesize($files[$imageNameInFiles]["tmp_name"]);
        if($check === false) {
            var_dump('check');
            return -1;
        }

        if (file_exists($target_file)) {
            var_dump('exists');
            return -1;
        }

        if ($files[$imageNameInFiles]["size"] > 5000000) {
            return -1;
        }

        if($extension != "jpg" && $extension != "png" && $extension != "jpeg" ) {
            return -1;
        }

        if (!move_uploaded_file($files["$imageNameInFiles"]["tmp_name"], $target_file)){
            return -1;
        }

        if (isset($description, $imageNameInFiles, $imageNameToStore)){
            if (str_contains($imageNameToStore, '.png') || str_contains($imageNameToStore, '.jpg') || str_contains($imageNameToStore, '.jpeg')){
                return $this->addImageToDatabaseDescription($imageNameToStore, $description);
            }
            else{
                return $this->addImageToDatabaseDescription($imageNameToStore.'.'.$extension, $description);
            }
        }
        else{
            if (str_contains($imageNameToStore, '.png') || str_contains($imageNameToStore, '.jpg') || str_contains($imageNameToStore, '.jpeg')){
                return $this->addImageToDatabase($imageNameToStore);
            }
            else{
                return $this->addImageToDatabase($imageNameToStore.'.'.$extension);
            }
        }
    }
}