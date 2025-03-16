<?php
class Post {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add($title, $content, $userId) {
        $query = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', $userId)";
        $this->conn->query($query);
    }

    public function edit($id, $title, $content) {
        $query = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
        $this->conn->query($query);
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM posts");
    }
}
?>
