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
        return $this->db->insert($sql, ['name' => $name, 'description' => $description]);
    }

    public function addImage($files, $imageNameInFiles, $imageNameToStore, $description){
        $target_dir = "Images/";
        $extension = strtolower(pathinfo($files[$imageNameInFiles]['name'],PATHINFO_EXTENSION));
        $target_file = $target_dir .$imageNameToStore.'.'.$extension;

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

        if (!move_uploaded_file($files["profile_image"]["tmp_name"], $target_file)){
            return -1;
        }

        if (isset($description, $imageNameInFiles, $imageNameToStore)){
            return $this->addImageToDatabaseDescription($imageNameToStore.'.'.$extension, $description);
        }
        else{
            return $this->addImageToDatabase($imageNameToStore.'.'.$extension);
        }
    }
}