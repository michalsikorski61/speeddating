<!DOCTYPE html>
<html>
<head>
    <title>Speed Dating</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Speed Dating</h1>
    <h2>Logowanie Użytkownika</h2>
    <form action="login_user.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Zaloguj">
    </form>
    
    <br>
    <a href="admin_login.php">Logowanie Administratora</a>
    </div>
</body>
</html>
