<?php

class ArticleRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getArticles($page)
    {
        if (!is_numeric($page)){
            header('Location: index.php');
            die();
        }

        $limit = 10;
        $offset = (($page -1) * 10) -5;

        if ($page == 1){
            $limit = 5;
            $offset = 0;
        }

        $sql = "SELECT a.*, au.name as a_name, au.surname as a_surname, i.path FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                INNER JOIN images i on i.id = a.id_image
                WHERE a.visible = 1 
                ORDER BY a.date DESC limit $offset, $limit";
        return $this->db->select($sql);
    }

    public function deleteArticle($id)
    {
        $sql = 'DELETE FROM articles where id = :id';
        $this->db->delete($sql, $id);
    }

    public function addArticle($params = [])
    {
        $sql = 'INSERT INTO articles values(default, :date, :id_author,:title, :text, :visible, :id_image, 0)';
        return $this->db->insert($sql, $params);
    }

    public function updateArticle($params = [])
    {
        $sql = 'UPDATE articles SET date = :date, id_author = :id_author,
                title = :title, text = :text , visible = :visible, id_image = :id_image
                WHERE id = :id';
        $this->db->update($sql, $params);
    }

    public function getArticle($id)
    {
        $sql = 'SELECT a.*, au.name as a_name, au.surname as a_surname, i.path FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                INNER JOIN images i on i.id = a.id_image
                WHERE a.id = :id';
        $this->updateArticleViews($id);
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function getArticlesByAuthor($id)
    {
        $sql = 'SELECT a.*, au.name, au.surname, i.path FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                INNER JOIN images i on i.id = a.id_image
                WHERE a.id_author = :id';
        return $this->db->selectWithParams($sql, ['id' => $id]);
    }

    public function getArticlesByCategory($id)
    {
        $sql = 'SELECT a.*, i.path, au.name, au.surname FROM articles a INNER JOIN category_assigns c on c.id_article = a.id
                INNER JOIN images i on i.id = a.id_image
                INNER JOIN users au on au.id = a.id_author
                WHERE c.id_category = :id';
        return $this->db->selectWithParams($sql, ['id' => $id]);
    }

    public function getAllArticles($page)
    {
        if (!is_numeric($page)){
            header('Location: index.php');
            die();
        }

        $offset = ($page - 1) * 10;

        $sql = "SELECT a.*,au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                ORDER BY a.date DESC
                LIMIT $offset, 10";
        return $this->db->select($sql);
    }

    public function getArticleAuthor($id)
    {
        $sql = 'SELECT a.id_author FROM articles a WHERE a.id = :id';
        return $this->db->selectOne($sql, ['id' => $id])['id_author'];
    }

    public function findArticles($search){
        $sql = 'SELECT a.*,au.name as a_name, au.surname as a_surname FROM articles a 
                INNER JOIN users au on a.id_author = au.id
                WHERE a.title like :search
                ORDER BY a.date DESC';
        return $this->db->selectWithParams($sql, ['search' => $search]);
    }

    private function updateArticleViews($id){
        $sql = 'UPDATE articles SET views = views + 1 where id = :id';
        $this->db->update($sql, ['id' => $id]);
    }

    public function getPagesNumber(){
        $sql = 'SELECT (COUNT(id) - 5) as num FROM articles';
        $res = $this->db->selectOne($sql)['num'];

        if($res > 0){
            return ceil($res / 10) + 1;
        }
        return 1;
    }

    public function getPagesNumberAdministration(){
        $sql = 'SELECT COUNT(id) as num FROM articles';
        $res = $this->db->selectOne($sql)['num'];
        return ceil($res / 10);
    }
}