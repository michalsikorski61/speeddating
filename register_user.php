<?php
require 'Database.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$event_id = $_POST['event_id'];

$db = new Database();

$db->query("INSERT INTO users (name, email, phone, password, event_id) VALUES (:name, :email, :phone, :password, :event_id)");
$db->bind(':name', $name);
$db->bind(':email', $email);
$db->bind(':phone', $phone);
$db->bind(':password', $password);
$db->bind(':event_id', $event_id);

if ($db->execute()) {
    // Logowanie operacji rejestracji
    $db->logActivity($db->lastInsertId(), 'Rejestracja użytkownika');
    echo "Rejestracja zakończona sukcesem!";
} else {
    echo "Błąd: " . $db->getError();
}
?>
<a href="index.php">Wróć</a>
