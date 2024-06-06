<?php
require 'config.php';
// Reszta kodu
?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require 'Database.php';
$db = new Database();

// Pobierz wszystkich użytkowników z wyjątkiem zalogowanego użytkownika
$db->query("SELECT * FROM users WHERE id != :user_id");
$db->bind(':user_id', $_SESSION['user_id']);
$users = $db->resultset();

// Pobierz aktualne wybory zalogowanego użytkownika
$db->query("SELECT choice_id FROM choices WHERE user_id = :user_id");
$db->bind(':user_id', $_SESSION['user_id']);
$choices = $db->resultset();
$selectedChoices = array_column($choices, 'choice_id');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Użytkownika</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Panel Użytkownika</h1>
        <form action="save_choices.php" method="post">
            <?php foreach ($users as $user): ?>
                <input type="checkbox" name="choices[]" value="<?php echo $user['id']; ?>" <?php echo in_array($user['id'], $selectedChoices) ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?><br>
            <?php endforeach; ?>
            <input type="submit" value="Zapisz wybory">
        </form>
        <a href="logout.php">Wyloguj</a>
    </div>
</body>
</html>
