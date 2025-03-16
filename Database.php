<?php
class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("127.0.0.1", "user", "password", "blog_db", 3306);
        if ($this->conn->connect_error) {
            die("Błąd połączenia: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
