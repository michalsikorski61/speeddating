<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
</head>
<body>
    <h1>Rejestracja</h1>
    <form action="register_user.php" method="post">
        <label for="name">Imię:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="phone">Numer telefonu:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <label for="event_id">Wybierz wydarzenie:</label>
        <select name="event_id" id="event_id" required>
            <?php
            $conn = new mysqli('localhost', 'root', '', 'speeddating');
            $result = $conn->query("SELECT id, name FROM events");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            $conn->close();
            ?>
        </select>
        <br>
        <input type="submit" value="Zarejestruj">
    </form>
</body>
</html>
