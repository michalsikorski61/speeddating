<?php
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'Database.php';

$db = new Database();

if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę create_event.php bez logowania .');
    exit;
}

?>

<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>Stwórz wydarzenie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Stwórz wydarzenie</h1>
    <form action="create_event_action.php" method="post">
        <label for="name">Nazwa wydarzenia:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="city">Miasto:</label>
        <input type="text" name="city" id="city" required>
        <br>
        <input type="submit" value="Stwórz">
    </form>
    </div>
</body>
</html>
