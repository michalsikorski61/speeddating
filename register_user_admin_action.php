<?php
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'Database.php';

$db = new Database();

// Sprawdzenie statusu sesji i uruchomienie sesji, jeśli nie jest aktywna
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę register_user_admin_action.php bez wysłania forma .');
    exit;
}


$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$event_id = $_POST['event_id'];



$db->query("INSERT INTO users (name, email, phone, password, event_id) VALUES (:name, :email, :phone, :password, :event_id)");
$db->bind(':name', $name);
$db->bind(':email', $email);
$db->bind(':phone', $phone);
$db->bind(':password', $password);
$db->bind(':event_id', $event_id);

if ($db->execute()) {
    echo "Rejestracja zakończona sukcesem!";
} else {
    echo "Błąd: " . $db->getError();
}
?>
<a href="admin_panel.php">Wróć</a>
