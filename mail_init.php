<?php
require_once 'config.php';

require_once 'Database.php';

$db = new Database();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę admin_panel.php bez logowania .');
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-color: #333;
        }
        form{
            background-color: #888;
        }
        h1{
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel Administratora</h1>
        <!-- Linki do różnych funkcji administratora -->
        <a href="view_matches.php">Podgląd par</a><br>
        <a href="register_user_admin.php">Rejestracja użytkownika</a><br>
        <a href="register_admin.php">Rejestracja administratora</a><br>
        <a href="create_event.php">Stwórz wydarzenie</a><br>
        <a href="logout.php">Wyloguj</a>
    </div>
</body>
</html>
