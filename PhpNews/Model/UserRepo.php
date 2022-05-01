<?php

class UserRepo
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAuthors(){
        $sql = 'SELECT u.id as id, u.name as name, u.surname as surname,
                u.username as username, u.email as email, u.id_role as id_role,
                r.name as role_description, u.description as description, u.image_url as image_url
                FROM users u INNER JOIN 
                roles r on r.id = u.id_role';
        return $this->db->select($sql);
    }

    public function addAuthor($params = []){
        $sql = 'INSERT INTO users values(default, :name, :surname, :username, :email, :password, :id_role, :image_url, :description)';
        $this->db->insert($sql, $params);
    }

    public function deleteAuthor($id){
        $sql = 'DELETE FROM users where id = :id';
        $this->db->delete($sql, $id);
    }

    public function updateAuthor($params = []){
        $sql = 'UPDATE users set name = :name, surname = :surname, username = :username, email = :email,
                 password = :password,id_role = :id_role, image_url = :image_url,
                 description = :description where id = :id';

        $this->db->update($sql, $params);
    }

    public function updateWithoutPassword($params = []){
        $sql = 'UPDATE users set name = :name, surname = :surname, username = :username, email = :email,
                 id_role = :id_role, image_url = :image_url,
                 description = :description where id = :id';

        $this->db->update($sql, $params);
    }


    public function getArticlesByAuthor($id){
        $sql = 'SELECT * as count FROM articles a where a.id_author = :id';
        return $this->db->selectWithParams($sql, $id);
    }

    public function getAuthor($id){
        $sql = 'SELECT * FROM users where id = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function canDeleteAuthor($id): bool
    {
        $sql = 'SELECT COUNT(0) as count FROM articles WHERE id_author = :id';
        $res  = $this->db->selectOne($sql, ['id' => $id]);
        return $res['count'] == 0;
    }
}