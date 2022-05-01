<?php

class LoginRepo
{
  protected $db;

  public function __construct(Database $db){
      $this->db = $db;
  }

  public function login($username){
      $sql = 'SELECT a.id as id, a.name as name, a.surname as surname, a.username as username, r.name as role,
              email as email, a.image_url as image_url, r.id as role_id FROM users a
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
                         :password, 2, :image_url, :description)';
      $this->db->insert($sql, $params);
  }

  public function usernameExists($username):bool{
      $sql = 'SELECT id FROM users WHERE username = :username';
      $res = $this->db->selectOne($sql, ['username' => $username]);
      return $res != false;
  }

  public function emailExists($email):bool{
      $sql = 'SELECT id FROM users WHERE email = :email';
      $res = $this->db->selectOne($sql, ['email' => $email]);
      return $res != false;
  }
}
?>