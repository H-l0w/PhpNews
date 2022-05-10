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

    public function assignArticleToCategory($idArticle, $idCategory){
        $sql = 'INSERT INTO category_assigns VALUES(DEFAULT, :id_category, :id_article)';
        return $this->db->insert($sql, ['id_category' => $idCategory, 'id_article' => $idArticle]);
    }

    public function deleteCategoryAssign($idArticle, $idCategory){
        $sql = 'DELETE FROM category_assigns where id_category = :id_category and id_article = :id_article';
        $this->db->deleteWithParams($sql, ['id_article' => $idArticle, 'id_category' => $idCategory]);
    }

    public function getBareCategories(){
        $sql = 'SELECT c.name, c.id FROM categories c';
        return $this->db->select($sql);
    }

    public function getCategoriesForArticle($idArticle){
        $sql = 'SELECT c.name, c.id FROM category_assigns cs
                INNER JOIN categories c on c.id = cs.id_category
                WHERE cs.id_article = :id_article';
        return $this->db->selectWithParams($sql, ['id_article' => $idArticle]);
    }

    public function findCategories($search){
        $sql = 'SELECT c.*, i.path FROM categories c INNER JOIN images i on i.id = c.id_image
                WHERE c.name LIKE :search or c.description like :search';
        return $this->db->selectWithParams($sql, ['search' => $search]);
    }
}