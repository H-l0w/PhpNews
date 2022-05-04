<?php

class ArticleRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getArticles(){
        $sql = 'SELECT a.*, au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                WHERE a.visible = 1
                ORDER BY a.date DESC limit 10';
        return $this->db->select($sql);
    }

    public function deleteArticle($id){
        $sql = 'DELETE FROM articles where id = :id';
        $this->db->delete($sql, $id);
    }

    public function addArticle($params = []){
        $sql = 'INSERT INTO articles values(default, :date, :id_author, :id_category,:title, :text, :visible, :image_url)';
        $this->db->insert($sql, $params);
    }

    public function updateArticle($params = []){
        $sql = 'UPDATE articles SET date = :date, id_author = :id_author, id_category = :id_category,
                title = :title, text = :text , visible = :visible, image_url = :image_url
                WHERE id = :id';
        $this->db->update($sql, $params);
    }

    public function getArticle($id){
        $sql = 'SELECT a.*, au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                WHERE a.id = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function getArticlesByAuthor($id){
        $sql = 'SELECT a.*, c.name as name, au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN categories c on a.id_category = c.id
                INNER JOIN users au on a.id_author = au.id
                WHERE a.id_author = :id';
        return $this->db->selectWithParams($sql, ['id' => $id]);
    }

    public function getArticlesByCategory($id){
        $sql = 'SELECT a.*, c.name as name,c.id as id_category, au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN categories c on a.id_category = c.id
                INNER JOIN users au on a.id_author = au.id
                WHERE c.id = :id';
        return $this->db->selectWithParams($sql, ['id' => $id]);
    }

    public function getAllArticles(){
        $sql = 'SELECT a.*,au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                ORDER BY a.date DESC';
        return $this->db->select($sql);
    }

    public function getArticleAuthor($id){
        $sql = 'SELECT a.id_author FROM articles a WHERE a.id = :id';
        return $this->db->selectOne($sql, ['id' => $id])['id_author'];
    }
}