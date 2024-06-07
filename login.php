<?php
require 'config.php';
// przekierowanie do panelu użytkownika, jeśli jest zalogowany
if (isset($_SESSION['user_id'])) {
    header('Location: user_panel.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Logowanie</h1>
    <form action="login_user.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Zaloguj">
    </form>
    </div>
</body>
</html>
