<?php
require 'config.php';
// Reszta kodu
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
            require 'Database.php';
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
