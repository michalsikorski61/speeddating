<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require 'Database.php';
$db = new Database();
$db->query("SELECT * FROM users WHERE id != :user_id");
$db->bind(':user_id', $_SESSION['user_id']);
$users = $db->resultset();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Użytkownika</title>
</head>
<body>
    <h1>Panel Użytkownika</h1>
    <form action="save_choices.php" method="post">
        <?php foreach ($users as $user): ?>
            <input type="checkbox" name="choices[]" value="<?php echo $user['id']; ?>">
            <?php echo $user['name']; ?><br>
        <?php endforeach; ?>
        <input type="submit" value="Zapisz wybory">
    </form>
    <a href="logout.php">Wyloguj</a>
</body>
</html>
