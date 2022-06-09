<?php

class SearchRepo
{
    protected $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function search($search, $page)
    {
        if (!is_numeric($page)){
            header('Location: index.php');
            die();
        }

        $offset = ($page - 1) * 10;
        $sql = "SELECT a.id, a.title as name, i.path, 'Článek' as type, a.text as detail FROM articles a
                INNER JOIN images i ON i.id = a.id_image
                WHERE a.title LIKE :search AND a.visible = 1
                UNION
                SELECT c.id, c.name as name, i.path, 'Kategorie' AS type, c.description as detail FROM categories c
                INNER JOIN images i ON i.id = c.id_image
                WHERE c.description LIKE :search
                UNION
                SELECT u.id, CONCAT(u.name, ' ', u.surname) AS name, i.path, 'Autor' AS type, u.description from users u
                INNER JOIN images i ON i.id = u.id_image
                WHERE u.name LIKE :search  OR u.surname LIKE :search OR u.username LIKE :search
                LIMIT $offset, 10";
        return $this->db->selectWithParams($sql, ['search' => $search]);
    }

    public function getNumberOfPages($search){
        $sql = 'SELECT SUM(num) as total from (
                    SELECT COUNT(0) as num FROM articles a
                    INNER JOIN images i ON i.id = a.id_image
                    WHERE a.title LIKE :search AND a.visible = 1
                    UNION ALL
                    SELECT COUNT(0) as num FROM categories c
                    INNER JOIN images i ON i.id = c.id_image
                    WHERE c.description LIKE :search
                    UNION ALL
                    SELECT COUNT(0) as num from users u
                    INNER JOIN images i ON i.id = u.id_image
                    WHERE u.name LIKE :search  OR u.surname LIKE :search OR u.username LIKE :search
                ) x';

        $res = $this->db->selectOneWithParams($sql, ['search' => $search])['total'];

        if($res > 0){
            return ceil($res / 10);
        }
        return 1;
    }
}