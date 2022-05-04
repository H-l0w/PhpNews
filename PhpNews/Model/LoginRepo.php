<?php

class LoginRepo
{
  protected $db;

  public function __construct(Database $db){
      $this->db = $db;
  }

  public function login($username){
      $sql = 'SELECT a.id as id, a.name as name, a.surname as surname, a.username as username, r.name as role,
              email as email, a.id_image as id_image, r.id as role_id FROM users a
              INNER JOIN roles r on r.id = a.id_role
              where username = :username or email = :username';

      return $this->db->selectOne($sql, ['username' => $username]);
  }

  public function getPasswordForUser($username){
      $sql = 'SELECT u.password from users u where username = :username or email = :username';

      return $this->db->selectOne($sql, ['username' => $username]);
  }

  public function register($params = []){
      $sql = 'INSERT INTO users VALUES(DEFAULT, :name, :surname, :username, :email, 
                         :password, 2, :id_image, :description)';
      $this->db->insert($sql, $params);
  }
}
?>