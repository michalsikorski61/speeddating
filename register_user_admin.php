<?php
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Database.php';

$db = new Database();

// Sprawdzenie statusu sesji i uruchomienie sesji, jeśli nie jest aktywna
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę register_user_admin.php bez logowania .');
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja Użytkownika</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Rejestracja Użytkownika</h1>
    <form action="register_user_admin_action.php" method="post">
    <select name="event_id" id="event_id" required>
            <?php
            
            $db = new Database();
            $db->query("SELECT id, name FROM events");
            $events = $db->resultset();
            foreach ($events as $event) {
                echo "<option value='" . $event['id'] . "'>" . $event['name'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="name">Imię:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="phone">Numer telefonu:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="event_id">Wybierz wydarzenie:</label>
        
        <input type="submit" value="Zarejestruj">
    </form>
    </div>
</body>
</html>
