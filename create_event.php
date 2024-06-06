<!DOCTYPE html>
<html>
<head>
    <title>Stwórz wydarzenie</title>
</head>
<body>
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
</body>
</html>
