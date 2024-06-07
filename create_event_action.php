<?php
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę create_event_action.php bez wysłania formularza.');
    exit;
}

$name = $_POST['name'];
$city = $_POST['city'];

$db->query("INSERT INTO events (name, city) VALUES (:name, :city)");
$db->bind(':name', $name);
$db->bind(':city', $city);

if ($db->execute()) {
    echo "Wydarzenie stworzone pomyślnie!";
} else {
    echo "Błąd wykonania: " . $db->getError();
}
?>
<a href="index.php">Wróć</a>
