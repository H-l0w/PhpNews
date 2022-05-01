<?php

class Database
{
    const HOST = 'localhost';
    const DBNAME = 'news';
    const USER = 'root';
    const PASSWORD = '';

    protected $conn;

    public function __construct()
    {
        $this->conn = new PDO(
            'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME,
            self::USER,
            self::PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $this->conn->query('SET NAMES utf8');
    }

    public function select($sql)
    {
        $stmt = $this->execute($sql);
        return $stmt->fetchAll();
    }

    public function selectWithParams($sql, $params = []){
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }

    public function selectOne($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch();
    }

    public function insert($sql, $params)
    {
        $stmt = $this->execute($sql, $params);
        return $this->conn->lastInsertId();
    }

    public function update($sql, $params)
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->rowCount();
    }

    public function delete($sql, $id){
        $stmt = $this->execute($sql, ['id' => $id]);
        return $stmt->rowCount();
    }

    protected function execute($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}