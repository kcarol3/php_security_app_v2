<?php
class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($username, $password) {
        $query = "INSERT INTO users (email, password) VALUES ('$username', '$password')";
        $this->conn->query($query);
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE email='$username' AND password='$password'";
        $result = $this->conn->query($query);
        return $result->num_rows > 0;
    }

    public function findUserIdByEmail(string $email): int
    {
        $query = "SELECT u.id FROM users u WHERE u.email='$email'";

        return (int) $this->conn->query($query)->fetch_object()->id;
    }

    public function edit($currentEmail, $newEmail, $newPassword) {
        $query = "UPDATE users SET email = '$newEmail', password = '$newPassword' WHERE email = '$currentEmail'";
        $this->conn->query($query);
    }
}
?>
