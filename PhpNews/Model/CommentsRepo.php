<?php

class CommentsRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addComment($params = []){
        $sql = 'INSERT INTO comments VALUES(default, :id_article, :name, :email, :text,now())';
        $this->db->insert($sql, $params);
    }

    public function getCommentsForArticle($id){
        $sql = 'SELECT * FROM comments WHERE id_article = :id';
        return $this->db->selectWithParams($sql, ['id' => $id]);
    }

    public function deleteComment($id){
        $sql = 'DELETE FROM comments WHERE id = :id';
        $this->db->delete($sql, $id);
    }

    public function getComments(){
        $sql = 'SELECT * FROM comments';
        return $this->db->select($sql);
    }

    public function getArticlesWithComments(){
        $sql = 'SELECT a.title AS title, a.id AS id, COUNT(0) as comments_count FROM comments c 
                INNER JOIN articles a on a.id = c.id_article
                GROUP BY c.id_article
                ORDER BY comments_count DESC';
        return $this->db->select($sql);
    }

    public function getArticlesWithCommentsByAuthor($id_author){
        $sql = 'SELECT a.title AS title, a.id AS id, COUNT(0) as comments_count FROM comments c 
                INNER JOIN articles a on a.id = c.id_article
                WHERE a.id_author = :id_author
                GROUP BY c.id_article
                ORDER BY comments_count DESC';
        return $this->db->selectWithParams($sql, ['id_author' => $id_author]);
    }
}