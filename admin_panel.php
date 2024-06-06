<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Administratora</title>
</head>
<body>
    <h1>Panel Administratora</h1>
    <a href="view_matches.php">Podgląd par</a><br>
    <a href="register_user_admin.php">Rejestracja użytkownika</a><br>
    <a href="register_admin.php">Rejestracja administratora</a><br>
    <a href="logout.php">Wyloguj</a>
</body>
</html>
