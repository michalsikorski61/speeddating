<?php
session_start();
require 'Database.php';

$db = new Database();

// Sprawdzenie, czy użytkownik lub administrator jest zalogowany
if (isset($_SESSION['user_id'])) {
    // Logowanie operacji wylogowania użytkownika
    $db->logActivity($_SESSION['user_id'], 'Wylogowanie użytkownika');
    session_destroy();
    header('Location: index.php');
} elseif (isset($_SESSION['admin_id'])) {
    // Sprawdzenie, czy admin_id istnieje w tabeli admins
    $db->query("SELECT id FROM admins WHERE id = :id");
    $db->bind(':id', $_SESSION['admin_id']);
    $admin = $db->single();
    if ($admin) {
        // Logowanie operacji wylogowania administratora
        $db->logActivity($_SESSION['admin_id'], 'Wylogowanie administratora');
    }
    session_destroy();
    header('Location: admin_login.php');
} else {
    header('Location: index.php');
}
?>
