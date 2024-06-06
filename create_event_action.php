<?php
require 'config.php';
// Reszta kodu
?>

<?php
require 'Database.php';

$name = $_POST['name'];
$city = $_POST['city'];

$db = new Database();

$db->query("INSERT INTO events (name, city) VALUES (:name, :city)");
$db->bind(':name', $name);
$db->bind(':city', $city);

if ($db->execute()) {
    echo "Wydarzenie stworzone pomyślnie!";
} else {
    echo "Błąd: " . $db->error;
}
?>
<a href="index.php">Wróć</a>
