<?php
session_start();
require 'Database.php';

$email = $_POST['email'];
$password = $_POST['password'];

$db = new Database();
$db->query("SELECT * FROM users WHERE email = :email");
$db->bind(':email', $email);
$user = $db->single();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: user_panel.php');
} else {
    echo "Niepoprawny email lub hasło.";
}
?>
<a href="index.php">Wróć</a>
