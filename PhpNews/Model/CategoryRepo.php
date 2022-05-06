<?php

class CategoryRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getCategories(){
        $sql = 'SELECT c.*, i.path FROM categories c INNER JOIN images i on i.id = c.id_image';
        return $this->db->select($sql);
    }

    public function deleteCategory($id){
        $sql = 'DELETE FROM categories where id = :id';
        $this->db->delete($sql, $id);
    }

    public function addCategory($params = []){
        $sql = 'INSERT INTO categories values(default, :name, :description, :id_image)';
        $this->db->insert($sql, $params);
    }

    public function updateCategory($params = []){
        $sql = 'UPDATE categories set name = :name, description = :description, id_image = :id_image where id = :id';
        $this->db->update($sql, $params);
    }

    public function getCategory($id){
        $sql = 'SELECT c.*, i.path FROM categories c INNER JOIN images i on i.id = c.id_image
                WHERE c.id = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function canBeDeleted($id){
        $sql = 'SELECT count(0) FROM category_assigns WHERE id_category = :id';
        return $this->db->selectOne($sql, ['id'=> $id]);
    }

    public function getNumArticlesForCategory($id){
        $sql = 'SELECT COUNT(0) from category_assigns where id_category = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }
}