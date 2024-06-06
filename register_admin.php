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
    <title>Rejestracja Administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Rejestracja Administratora</h1>
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