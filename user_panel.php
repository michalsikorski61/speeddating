<?php
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'Database.php';

$db = new Database();

// Sprawdzenie statusu sesji i uruchomienie sesji, jeśli nie jest aktywna
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę user_panel.php bez logowania .');
    exit;
}



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
