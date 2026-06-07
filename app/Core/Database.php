<?php

class Database {
    protected $conn = null;
    
    public function __construct() {
        try {
            $this->conn = new PDO(DB_TYPE.":host=".DB_SERVER.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        } catch (PDOException $e) {
            die('<h3>Database Not Connected</h3><p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>');
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
