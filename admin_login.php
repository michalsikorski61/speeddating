<?php
require 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Sprawdzenie, czy użytkownik jest zalogowany jako admin lub user
if (isset($_SESSION['admin_id'])) {
    // Przekierowanie na stronę index.php, jeśli nie jest zalogowany
    header('Location: admin_panel.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logowanie Administratora</title>
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
    <h1>Logowanie Administratora</h1>
    <form action="login_admin.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Zaloguj">
    </form>
    <a href="index.php">Logowanie Użytkownika</a>
    </div>
</body>
</html>
