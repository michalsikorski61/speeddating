<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja Administratora</title>
</head>
<body>
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
</body>
</html>
