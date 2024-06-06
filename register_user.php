<?php
require 'Database.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$event_id = $_POST['event_id'];

$db = new Database();

$db->query("INSERT INTO users (name, email, phone, event_id) VALUES (:name, :email, :phone, :event_id)");
$db->bind(':name', $name);
$db->bind(':email', $email);
$db->bind(':phone', $phone);
$db->bind(':event_id', $event_id);

if ($db->execute()) {
    echo "Rejestracja zakończona sukcesem!";
} else {
    echo "Błąd: " . $db->error;
}
?>
<a href="index.php">Wróć</a>
