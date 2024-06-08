<?php
require 'config.php';
// Reszta kodu
?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    
        echo("Tutaj cię nie mogę wpuścić. Wróć na stronę główną.");
        echo "<a href='index.php'>Wróć</a>";
        $db->logActivity($db->lastInsertId(), 'Ktoś próbował wejść na stronę view_matches.php bez  logowania.');
        header('Location: index.php');
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
                $db->query("SELECT name FROM users WHERE id = :id");
                $db->bind(':id', $match['user1_id']);
                $user1 = $db->single();
                $db->query("SELECT name FROM users WHERE id = :id");
                $db->bind(':id', $match['user2_id']);
                $user2 = $db->single();
                ?>
                <li><?php echo htmlspecialchars($user1['name'], ENT_QUOTES, 'UTF-8'); ?> i <?php echo htmlspecialchars($user2['name'], ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="admin_panel.php">Wróć</a>
    </div>
</body>
</html>
