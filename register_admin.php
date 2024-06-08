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
if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę register_admin.php bez logowania .');
    header('Location: index.php');
    exit;
}
// jeśli jest zalogowany jako użytownik, przekieruj do index.php
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja Administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Rejestracja Administratora</h1>
        <!-- Formularz rejestracji administratora -->
        <form action="register_admin_action.php" method="post">
            <label for="name">Imię:</label>
            <input type="text" name="name" id="name" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br>
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="submit" value="Zarejestruj">
        </form>
    </div>
</body>
</html>
