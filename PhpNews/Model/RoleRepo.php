<?php

class RoleRepo
{
    protected $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function getRoles(){
        $sql = 'SELECT * FROM roles';
        return $this->db->select($sql);
    }

    public function getRole($id){
        $sql = 'SELECT * FROM roles where id = :id';
        return $this->db->selectOne($sql, ['id' => $id]);
    }

    public function addRole($params = []){
        $sql = 'INSERT INTO roles VALUES(DEFAULT, :name)';
        $this->db->insert($sql, $params);
    }

    public function deleteRole($id){
        $sql = 'DELETE FROM roles WHERE id = :id';
        $this->db->delete($sql, $id);
    }

    public function updateRole($params = []){
        $sql = 'UPDATE roles set name = :name where id = :id';
        $this->db->update($sql, $params);
    }

    public function hasRoleMembers($id):bool{
        $sql = 'SELECT COUNT(0) as count FROM users WHERE id_role = :id';
        $res  = $this->db->selectOne($sql, ['id' => $id]);
        return $res['count'] > 0;
    }
}