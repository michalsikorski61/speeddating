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
    $db->logActivity(null, 'Ktoś próbował wejść na stronę admin_panel.php bez logowania .');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Panel Administratora</h1>
        <!-- Linki do różnych funkcji administratora -->
        <a href="view_matches.php">Podgląd par</a><br>
        <a href="register_user_admin.php">Rejestracja użytkownika</a><br>
        <a href="register_admin.php">Rejestracja administratora</a><br>
        <a href="logout.php">Wyloguj</a>
    </div>
</body>
</html>
