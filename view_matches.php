<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

require 'Database.php';
$db = new Database();

// Pobierz wszystkie wzajemne wybory
$db->query("
    SELECT c1.user_id AS user1_id, c1.choice_id AS user2_id
    FROM choices c1
    JOIN choices c2 ON c1.user_id = c2.choice_id AND c1.choice_id = c2.user_id
    WHERE c1.user_id < c1.choice_id
");
$matches = $db->resultset();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Podgląd Par</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Podgląd Par</h1>
    <ul>
        <?php foreach ($matches as $match): ?>
            <?php
            $db->query("SELECT name,email FROM users WHERE id = :id");
            $db->bind(':id', $match['user1_id']);
            $user1 = $db->single();
            $db->query("SELECT name,email FROM users WHERE id = :id");
            $db->bind(':id', $match['user2_id']);
            $user2 = $db->single();
            ?>
            <li><?php echo $user1['name'].' '. $user1['email']; ?> i <?php echo $user2['name'].' '.$user2['email']; ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="admin_panel.php">Wróć</a>
    </div>
</body>
</html>
