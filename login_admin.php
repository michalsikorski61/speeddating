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
    echo "Niepoprawny email lub hasło.";
}
?>
<a href="admin_login.php">Wróć</a>
