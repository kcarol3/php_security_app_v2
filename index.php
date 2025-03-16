<?php
session_start();
require_once 'Database.php';
require_once 'User.php';
require_once 'Post.php';

$db = new Database();
$user = new User($db->getConnection());
$post = new Post($db->getConnection());


if (isset($_POST['addPost']) && isset($_SESSION['user'])) {
    $userID = $user->findUserIdByEmail($_SESSION['user']);
    $post->add($_POST['title'], $_POST['content'], $userID);
}

if (isset($_POST['edit_post']) && isset($_SESSION['user'])) {
    $post->edit($_POST['id'], $_POST['title'], $_POST['content']);
}

if (isset($_POST['edit_user']) && isset($_SESSION['user'])) {
    $user->edit($_SESSION['user'], $_POST['new_email'], $_POST['new_password']);
    $_SESSION['user'] = $_POST['new_email'];
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$posts = $post->getAll();

?>
<!DOCTYPE html>
<html lang="pl">
<head><title>Blog</title></head>
<body>
<h1> Witaj <?php echo $_SESSION['user'] ?? '' ?></h1>
<h2>Edycja konta</h2>
<form method="POST">
    <input type="email" name="new_email" placeholder="Nowy email" value="<?= $_SESSION['user'] ?? '' ?>">
    <input type="password" name="new_password" placeholder="Nowe hasło">
    <button type="submit" name="edit_user">Zapisz zmiany</button>
</form>
<h2>Wylogowanie</h2>
<form method="POST">
    <button type="submit" name="logout">Wyloguj</button>
</form>
<h2>Add post</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Tytuł">
    <textarea name="content" placeholder="Treść"></textarea>
    <button type="submit" name="addPost">Add</button>
</form>
<h2>Posts</h2>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $posts->fetch_assoc()): ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['content'] ?></td>
            <td>
                <button onclick="showEditForm(<?= $row['id'] ?>)">Edit</button>
            </td>
        </tr>
        <tr id="edit-form-<?= $row['id'] ?>" style="display: none;">
            <td colspan="3">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="text" name="title" value="<?= $row['title'] ?>">
                    <textarea name="content"><?= $row['content'] ?></textarea>
                    <button type="submit" name="edit_post">Edytuj</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>

    <script>
        function showEditForm(id) {
            var formRow = document.getElementById('edit-form-' + id);
            if (formRow.style.display === 'none') {
                formRow.style.display = 'table-row';
            } else {
                formRow.style.display = 'none';
            }
        }
    </script>
</table>
</body>
</html>
