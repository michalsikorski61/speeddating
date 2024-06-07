<?php
require 'Database.php';

$db = new Database();
$db->query("SELECT 1");
if ($db->execute()) {
    echo "Połączenie z bazą danych działa poprawnie.";
    // Pobierz wszystkie wzajemne wybory
    $db->query("SELECT * FROM `logs` ORDER BY timestamp DESC;");
    $matches = $db->resultset();
    foreach ($matches as $match) {
        echo "<br>";
        echo $match['timestamp'] . " " . $match['user_id'] . " " . $match['action'];
    }
} else {
    echo "Błąd połączenia z bazą danych: " . $db->getError();
}
?>

