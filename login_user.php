<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// Używamy require_once zamiast require
require_once 'Database.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$db = new Database();

$db->query("SELECT * FROM users WHERE email = :email");
$db->bind(':email', $email);
$user = $db->single();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    // Logowanie operacji logowania
    $db->logActivity($user['id'], 'Logowanie użytkownika');
    header('Location: user_panel.php');
    exit;
} else {
    // Logowanie nieudanego logowania
    $db->logFailedLogin($email);
    $error_message = "Niepoprawny email lub hasło. Spróbuj ponownie.";
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
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
                <img src="https://media.tenor.com/pl/view/alert-frog-gif-15005995807871958954.gif" alt="Alert Frog GIF">
            </div>
        <?php endif; ?>
        <a href="index.php">Wróć
