<!DOCTYPE html>
<html>
<head>
    <title>Logowanie Administratora</title>
</head>
<body>
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
</body>
</html>
