<?php

class CategoryRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getCategories(){
        $sql = 'SELECT * FROM categories';
        return $this->db->select($sql);
    }

    public function deleteCategory($id){
        $sql = 'DELETE FROM categories where id = :id';
        $this->db->delete($sql, $id);
    }

    public function addCategory($params = []){
        $sql = 'INSERT INTO categories values(default, :name, :description, :image_url)';
        $this->db->insert($sql, $params);
    }

    public function updateCategory($params = []){
        $sql = 'UPDATE categories set name = :name, description = :description, image_url = :image_url where id = :id';
        $this->db->update($sql, $params);
    }

    public function getCategory($id){
        $sql = 'SELECT * FROM categories WHERE id = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function canBeDeleted($id){
        $sql = 'SELECT count(0) FROM category_assigns WHERE id_category = :id';
        return $this->db->selectOne($sql, ['id'=> $id]);
    }
}