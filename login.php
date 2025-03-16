<?php
session_start();
require_once 'Database.php';
require_once 'User.php';
require_once 'Post.php';

$db = new Database();
$user = new User($db->getConnection());
$post = new Post($db->getConnection());

if (isset($_POST['register'])) {
    $user->register($_POST['email'], $_POST['password']);
}

if (isset($_POST['login'])) {
    if ($user->login($_POST['email'], $_POST['password'])) {
        $_SESSION['user'] = $_POST['email'];
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head><title>Blog</title></head>
<body>
<h2>Rejestracja</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Hasło">
    <button type="submit" name="register">Zarejestruj</button>
</form>
<h2>Logowanie</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Hasło">
    <button type="submit" name="login">Zaloguj</button>
</form>
</body>
</html>