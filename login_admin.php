<?php
session_start();
require 'Database.php';

$email = $_POST['email'];
$password = $_POST['password'];

$db = new Database();

$db->query("SELECT * FROM admins WHERE email = :email");
$db->bind(':email', $email);
$admin = $db->single();

if ($admin && password_verify($password, $admin['password'])) {
    $_SESSION['admin_id'] = $admin['id'];
    // Logowanie operacji logowania administratora
    $db->logActivity($admin['id'], 'Logowanie administratora');
    header('Location: admin_panel.php');
} else {
    // Logowanie nieudanego logowania
    $db->logFailedLogin($email);
    $error_message = "Niepoprawny email lub hasło. Spróbuj ponownie.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logowanie Administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
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
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
                <img src="https://media.tenor.com/pl/view/alert-frog-gif-15005995807871958954.gif" alt="Alert Frog GIF">
            </div>
        <?php endif; ?>
        <a href="admin_login.php">Wróć</a>
    </div>
</body>
</html>
