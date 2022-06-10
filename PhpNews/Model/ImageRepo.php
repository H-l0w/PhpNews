<?php

class ImageRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    private function addImageToDatabase($name, $path){
        $sql = 'INSERT INTO images (id, name, path) values (default, :name, :path)';
        return $this->db->insert($sql, ['name' => $name, 'path' => $path]);
    }

    private function addImageToDatabaseDescription($name, $description, $path){
        $sql = 'INSERT INTO images values (default, :name, :description, :path)';
        return $this->db->insert($sql, ['name' => $name, 'description' => $description, 'path' => $path]);
    }

    public function getImages($page, $limit = 12){
        if (!is_numeric($page) || !is_numeric($limit)){
            header('Location: index.php');
            die();
        }
        $offset = ($page - 1) * 10;

        if ($page === -1)
            $sql = 'SELECT * FROM images';
        else
            $sql = "SELECT * FROM images LIMIT $offset, $limit";
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

    public function getPagesNumber(){
        $sql = 'SELECT COUNT(id) as num FROM images';
        $res = $this->db->selectOne($sql)['num'];
        return ceil($res / 10);
    }

    public function getImageForArticle($id){
        $sql = 'SELECT i.path FROM articles a
                INNER JOIN images i ON i.id = a.id_image
                WHERE a.id = :id';
        return $this->db->selectOne($sql, ['id' => $id])['path'];
    }

    public function getImageForAuthor($id){
        $sql = 'SELECT i.path FROM users u
                INNER JOIN images i ON i.id = u.id_image
                WHERE u.id = :id';

        return $this->db->selectOne($sql, ['id' => $id])['path'];
    }

    public function getImageForCategory($id){
        $sql = 'SELECT i.path FROM categories c
                INNER JOIN images i ON i.id = c.id_image
                WHERE c.id = :id';
        return $this->db->selectOne($sql, ['id' => $id])['path'];
    }

    public function addImage($files, $imageNameInFiles, $imageNameToStore, $description){
        $target_dir = "Images/";
        $extension = strtolower(pathinfo($files[$imageNameInFiles]['name'],PATHINFO_EXTENSION));

        $target_file = uniqid().'.'.$extension;

        $check = getimagesize($files[$imageNameInFiles]["tmp_name"]);
        if($check === false) {
            return -1;
        }

        if (file_exists($target_file)) {
            return -1;
        }

        if ($files[$imageNameInFiles]["size"] > 5000000) {
            return -1;
        }

        if($extension != "jpg" && $extension != "png" && $extension != "jpeg" ) {
            return -1;
        }

        if (!move_uploaded_file($files["$imageNameInFiles"]["tmp_name"], $target_dir.$target_file)){
            return -1;
        }

        if (isset($description, $imageNameInFiles, $imageNameToStore)){
            return $this->addImageToDatabaseDescription($imageNameToStore, $description, $target_dir.$target_file);
        }
        else{
            return $this->addImageToDatabase($imageNameToStore, $target_dir.$target_file);
        }
    }
}