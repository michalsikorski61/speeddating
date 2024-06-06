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
